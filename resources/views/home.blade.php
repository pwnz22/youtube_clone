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
                        You are logged in.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
