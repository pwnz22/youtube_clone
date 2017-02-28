@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Channel settings</div>

                    <div class="panel-body">
                        <form action="/channel/{{ $channel->slug }}/edit" method="POST" enctype="multipart/form-data">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">Name</label>

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $channel->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div><!-- form-group -->

                            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="slug">Unique URL</label>

                                <div class="input-group">
                                    <div class="input-group-addon">{{ config('app.url') }}/channel/</div>
                                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                                </div>

                                @if ($errors->has('slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div><!-- form-group -->

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description">Description</label>

                                <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>


                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div><!-- form-group -->

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image">Channel Image</label>

                                <input type="file" name="image" id="image">

                                {{-- @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif --}}
                            </div><!-- form-group -->
                            <button class="btn btn-default" type="submit">Update</button>
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
