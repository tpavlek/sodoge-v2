<?php

namespace Depotwarehouse\SoDoge\Http\Controllers;

use Depotwarehouse\SoDoge\Model\Shibe;

class Stats extends Controller
{

    protected $shibes;

    public function __construct(Shibe $shibes)
    {
        $this->shibes = $shibes;
    }

    public function topTen()
    {
        $shibes = $this->shibes->findTop(10);
        return view('stats.top10')
            ->with('shibes', $shibes);
    }
}
