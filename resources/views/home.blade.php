@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if ($subscriptionVideos->count())
                        @foreach($subscriptionVideos as $video)
                            <div class="well">
                                @include('video.partials._video_result', compact('video'))
                            </div>
                        @endforeach
                    @else
                        @if(Auth::user()->token)
                            @if($tweets->count())
                                @foreach($tweets as $tweet)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-object" src="https://placeholdit.imgix.net/~text?txtsize=8&txt=65%C3%9765&w=65&h=65" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <strong>{{ $tweet->user->name }}</strong>
                                            <p>{{ $tweet->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <p>Please <a href="{{ url('/auth/twitter') }}">authorize with Twitter</a></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
