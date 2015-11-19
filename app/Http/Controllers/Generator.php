<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

class Generator extends Controller
{
    /** @var \Depotwarehouse\SoDoge\Repositories\ShibeRepository  */
    protected $shibeRepository;

    public function __construct(\Depotwarehouse\SoDoge\Repositories\ShibeRepository $shibeRepository)
    {
        $this->shibeRepository = $shibeRepository;
    }


    /**
     * Show the form to begin creation of a Shibe.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return View::make('generator/index');
    }


    /**
     * Show the editor.
     *
     * @param $hash
     * @return \Illuminate\View\View
     */
    public function create($hash)
    {
        $file = Config::get('app.base_upload_dir') . $hash;
        if (!file_exists($file)) {
            $file = false;
            // TODO throw an exception here.
        } else {
            $image = array();
            $image['width'] = getimagesize($file)[0];
            $image['height'] = getimagesize($file)[1];
            $image['path'] = explode("public", $file)[1];
            $image['hash'] = $hash;
            $file = $image;
        }
        return View::make('generator/create', array('image' => $file));
    }

    private function getPhrasesFromArray(array $input)
    {

    }


    public function store($hash)
    {

        if (!Input::has('phrases')) {
            return Response::json(array(
                'status' => 1,
                'message' => "You did not seem to have uploaded any phrases",
                'data' => null
            ));
        }

        $path = Config::get('app.base_upload_dir') . $hash;
        if (!file_exists($path)) {
            return Response::json(array(
                'status' => 1,
                'message' => "Base file not found. You can save this data file for use later",
                'data' => Input::get('phrases')
            ));
        }


        $img = Image::make($path);
        $fontFile = storage_path() . '/fonts/comicsans.ttf';
        foreach (Input::get("phrases") as $phrase) {
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
        $tmpPath = Config::get('app.tmp_upload_dir') . explode(".", $hash)[0] . "_" . uniqid() . "." . $ext;
        $img->save($tmpPath);
        $newHash = hash_file("sha256", $tmpPath);
        rename($tmpPath, Config::get('app.finished_upload_dir') . $newHash . "." . $ext);


        $shibe = new Shibe;
        if (Auth::check()) {
            $shibe->user_id = Auth::user()->id;
        }
        if (Input::has("title")) {
            $shibe->title = Input::get('title');
        }
        $shibe->hash = $newHash . "." . $ext;
        $shibe->save();
        return Response::json(array(
            'status' => 0,
            'new_file' => $newHash . "." . $ext
        ));
    }

    /**
     * Display a completed Shibe.
     *
     * Has a side effect of incrementing the current views of that shibe by one.
     *
     * @param $hash
     * @return \Illuminate\View\View
     */
    public function show($hash)
    {
        try {
            $shibe = $this->shibeRepository->findByHash($hash);
            $filePath = Config::get('app.finished_upload_dir') . $hash;

            if (!file_exists($filePath)) {
                App::abort(404, 'shibe gone wow');
                Log::error('Shibe with ID: ' . $shibe->id . " not found");
            }

            $shibe->views++;
            $shibe->save();

            // We know the finished upload dir has the "string" public in it. We want everything after that.
            $imagePath = explode("public", $filePath)[1];
            return View::make('generator.show')
                ->with('imagePath', $imagePath)
                ->with('shibe', $shibe);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            App::abort(404, 'doge not found');
            return 1;
        }
    }
}
