@extends('layouts.myapp')

@section('page_title', __('site.action.create_entity', ['entity'=> __('site.option.single')]))

@section('content')

    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <form method="post" action="{{ route('options.store', [$survey])}}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="mb-3 d-flex flex-column justify-content-start">
                        <label for="title" class="form-label">{{__('site.option.field.title')}}</label>
                        <input type="text" class="form-control" id="title" name="title">
                        
                        <label for="image" class="form-label">{{__('site.option.field.image')}}</label>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg">
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('site.action.save')}}</button>
                    <a href="{{ route('options.index', [$survey]) }}" class="btn btn-light my-2">{{ __('site.action.return') }}</a>
                </form>

            </div>


        </div>
    </div>
@endsection


@push('scripts')
@endpush

@push('head_styles')
@endpush