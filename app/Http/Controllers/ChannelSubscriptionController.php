<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSubscriptionController extends Controller
{
    public function show(Request $request, Channel $channel)
    {
        $response = [
            'count' => $channel->subscriptionCount(),
            'user_subscribed' => false,
            'can_subscribed' => false
        ];

        if ($request->user()) {
            $response = array_merge($response, [
                'user_subscribed' => $request->user()->isSubscribedTo($channel),
                'can_subscribed' => !$request->user()->ownsChannel($channel)
            ]);
         }

        return response()->json($response, 200);
    }
}
