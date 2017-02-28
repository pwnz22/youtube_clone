<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        if (!request()->q)
            return redirect('/');

        $channels = Channel::search(request()->q)->take(5)->get();
        $videos = Video::search(request()->q)->get();

        return view('search.index', compact('channels', 'videos'));
    }
}
