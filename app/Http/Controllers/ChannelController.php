<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function show(Channel $channel) {
        $videos = $channel->videos()->latestFirst()->paginate(5);
        return view('channel.show', compact('channel', 'videos'));
    }
}
