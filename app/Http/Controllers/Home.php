<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Illuminate\Contracts\Config\Repository;

class Home extends Controller
{

    public function show(Repository $config)
    {
        return view('index')
            ->with('links', $config->get('app.links'))
            ->with('nav', true);
    }
}
