<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Depotwarehouse\SoDoge\Model\Shibe;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Generator extends Controller
{
    /**
     * Show the form to begin creation of a Shibe.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('generator.show');
    }


    /**
     * Show the shibe editor.
     *
     * @param $hash
     * @return \Illuminate\View\View
     */
    public function create($hash)
    {
        $filePath = config('app.base_upload_dir') . $hash;
        if (!\File::exists($filePath)) {
            throw new NotFoundHttpException("Couldn't find file {$hash}");
        }

        $image = [];
        $image['width'] = getimagesize($filePath)[0];
        $image['height'] = getimagesize($filePath)[1];
        // The path will start with "public" which we want to remove.
        $image['path'] = explode("public", $filePath)[1];
        $image['hash'] = $hash;

        return view('generator.create')
            ->with('image', $image);
    }


    public function store($hash, Request $request, ImageManager $imageService)
    {

        if (!$request->has('phrases')) {
            return response()->json([
                'status' => 1,
                'message' => "You did not seem to have uploaded any phrases",
                'data' => null
            ]);
        }

        $baseFilePath = config('app.base_upload_dir') . $hash;
        if (!\File::exists($baseFilePath)) {
            return response()->json(array(
                'status' => 1,
                'message' => "Base file not found. You can save this data file for use later",
                'data' => $request->input('phrases')
            ));
        }

        $img = $imageService->make($baseFilePath);
        $fontFile = storage_path() . '/fonts/comicsans.ttf';
        foreach ($request->input("phrases") as $phrase) {
            $img->text(
                $phrase['text'],
                $phrase['x_pos'],
                $phrase['y_pos'],
                function ($font) use ($phrase, $fontFile) {
                    $font->color = $phrase['color'];
                    $font->file = $fontFile;
                    $font->size = $phrase['font_size'];
                    $font->valign = "top"; // The frontend expects vertical alignment to be on the top
                }
            );
        }

        $ext = explode(".", $hash)[1];
        $tmpPath = config('app.tmp_upload_dir') . explode(".", $hash)[0] . "_" . uniqid() . "." . $ext;
        $img->save($tmpPath);
        $newHash = hash_file("sha256", $tmpPath);
        rename($tmpPath, config('app.finished_upload_dir') . $newHash . "." . $ext);


        $shibe = new Shibe();
        if (\Auth::check()) {
            $shibe->user_id = \Auth::user()->id;
        }
        if ($request->has("title")) {
            $shibe->title = $request->input('title');
        }
        $shibe->hash = $newHash . "." . $ext;
        $shibe->save();

        return response()->json([
            'status' => 0,
            'new_file' => $shibe->hash
        ]);
    }
}
