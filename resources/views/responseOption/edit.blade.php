@extends('layouts.myapp')

@section('page_title', __('site.action.edit_entity', ['entity'=> __('site.option.single')]))

@section('content')

    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <form method="post" action="{{ route('options.update', [$model]) }}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="mb-3 d-flex flex-column justify-content-start">
                        <label for="title" class="form-label">{{__('site.option.field.title')}}</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $model->title }}">

                        <label for="image" class="form-label">{{__('site.option.field.image')}}</label>
                        @if ($model->image != null)
                            <img src={{ $model->image }} class="img-thumbnail" alt="survey">
                        @endif
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg">
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('site.action.save')}}</button>
                    <a href="{{ route('options.index', [$model]) }}" class="btn btn-light my-2">{{ __('site.action.return') }}</a>
                </form>

            </div>


        </div>
    </div>
@endsection


@push('scripts')
@endpush

@push('head_styles')
@endpush
