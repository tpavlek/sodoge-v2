<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Depotwarehouse\SoDoge\Model\GeneratesImages;
use Depotwarehouse\SoDoge\Model\Shibe;
use Depotwarehouse\SoDoge\Model\ValueObjects\Phrase;
use Illuminate\Auth\Guard;
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


    public function store($hash, Request $request, GeneratesImages $generatesImages, Guard $auth, Shibe $shibes)
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
            return response()->json([
                'status' => 1,
                'message' => "Base file not found. You can save this data file for use later",
                'data' => $request->input('phrases')
            ]);
        }

        $phrases = collect($request->input('phrases'))->map(function ($phrase) {
            return new Phrase($phrase['text'], $phrase['x_pos'], $phrase['y_pos'], $phrase['color'], $phrase['font_size']);
        });

        $newHash = $generatesImages->generate($hash, $phrases);

        $attributes = [
            'hash' => $newHash
        ];
        if ($auth->check()) {
            $attributes['user_id'] = $auth->user()->id;
        }

        if ($request->has("title")) {
            $attributes['title'] = $request->input('title');
        }

        $shibe = $shibes->create($attributes);

        return response()->json([
            'status' => 0,
            'new_file' => $shibe->hash
        ]);
    }
}
