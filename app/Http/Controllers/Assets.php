<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

class Assets extends Controller
{

    public function upload()
    {
        $file = Input::file('shibe');
        $hash = hash_file('sha256', $file->getRealPath());
        $filename = $hash . "." . $file->getClientOriginalExtension();
        if (file_exists(Config::get('app.base_upload_dir') . $filename)) {
            return Response::json(array( 'status' => 0, 'hash' => $filename ));
        }

        $file->move(Config::get('app.base_upload_dir'), $filename);
        return Response::json(array( 'status' => 0, 'hash' => $filename ));
    }

}
