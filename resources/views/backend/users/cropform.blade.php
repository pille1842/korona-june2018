@extends('layouts.backend')

@section('title')
    {{ trans('backend.crop_picture') }}
@endsection

@section('content')

    <h1>{{ trans('backend.crop_picture') }}</h1>

    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <p>
                <img id="picture" src="{{ $user->profilePictureRoute() }}" style="max-width:100%;">
            </p>
            {{ Form::open(['route' => ['backend.user.picture.crop', $user]]) }}
                <button class="btn btn-primary btn-block" id="btnCrop">
                    Zuschneiden
                </button>
                <input type="hidden" id="x" name="x" value="">
                <input type="hidden" id="y" name="y" value="">
                <input type="hidden" id="width" name="width" value="">
                <input type="hidden" id="height" name="height" value="">
            {{ Form::close() }}
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $("#picture").cropper({
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            crop: function (e) {
                $("#x").val(e.x);
                $("#y").val(e.y);
                $("#width").val(e.width);
                $("#height").val(e.height);
            }
        });
    </script>
@endpush

@include('components.tool.cropper')
