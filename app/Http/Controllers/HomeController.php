<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class HomeController extends Controller
{
    protected $client;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guzzle $client)
    {
        $this->middleware('auth');
        $this->client = $client;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserRepository $users)
    {
        $tweets = collect();
        if ($request->user()->token) {
            $response = $this->client->get('http://api_auth/api/tweets', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->user()->token->access_token
                ]
            ]);

            $tweets = collect(json_decode($response->getBody()));
        }

        $subscriptionVideos = $users->videosFromSubscriptions($request->user());

        return view('home', compact('subscriptionVideos', 'tweets'));
    }

}
