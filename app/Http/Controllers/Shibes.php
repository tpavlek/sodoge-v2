<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Depotwarehouse\SoDoge\Model\Shibe;
use Illuminate\Contracts\Config\Repository;
use Monolog\Logger;

class Shibes extends Controller
{

    protected $shibes;

    public function __construct(Shibe $shibes)
    {
        $this->shibes = $shibes;
    }

    public function show($hash)
    {
        $shibe = $this->shibes->view($hash);

        return view('shibe.show')
            ->with('shibe', $shibe);
    }
}
