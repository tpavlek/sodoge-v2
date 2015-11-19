<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Depotwarehouse\SoDoge\Http\Requests\Request;
use Depotwarehouse\SoDoge\Model\SavesAssets;

class Assets extends Controller
{

    protected $savesAssets;

    public function __construct(SavesAssets $savesAssets)
    {
        $this->savesAssets = $savesAssets;
    }

    public function upload(Request $request)
    {
        $file = $request->file('shibe');
        $filename = $this->savesAssets->save($file);

        return response()->json([ 'status' => 0, 'hash' => $filename ]);
    }

}
