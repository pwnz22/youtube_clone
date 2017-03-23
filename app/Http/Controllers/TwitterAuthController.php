<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;

class TwitterAuthController extends Controller
{
    protected $client;
    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => '5',
            'redirect_uri' => 'http://youtubeclone/auth/twitter/callback',
            'response_type' => 'code',
            'scope' => 'view-tweets post-tweets'
        ]);

        return redirect('http://api_auth/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $response = $this->client->post('http://api_auth/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '5',
                'client_secret' => 'unwGexaiA8YYtgT0U6TXoFwce1EthFWRklcuXgDP',
                'redirect_uri' => 'http://youtubeclone/auth/twitter/callback',
                'code' => $request->code
            ]
        ]);

        $response = json_decode($response->getBody());

        $request->user()->token()->delete();

        $request->user()->token()->create([
            'access_token' => $response->access_token,
            'refresh_token' => $response->refresh_token,
            'expires_in' => $response->expires_in
        ]);

        return redirect('/home');
    }

    public function refresh(Request $request)
    {
        $response = $this->client->post('http://api_auth/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->user()->token->refresh_token,
                'client_id' => '5',
                'client_secret' => 'unwGexaiA8YYtgT0U6TXoFwce1EthFWRklcuXgDP',
                'scope' => 'view-tweets post-tweets'
            ]
        ]);

        $response = json_decode($response->getBody());

        $request->user()->token()->update([
            'access_token' => $response->access_token,
            'expires_in' => $response->expires_in,
            'refresh_token' => $response->refresh_token
        ]);

        return redirect()->back();
    }
}
