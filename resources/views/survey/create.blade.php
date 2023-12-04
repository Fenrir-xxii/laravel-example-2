@extends('layouts.myapp')

@section('page_title', __('site.action.create_entity', ['entity'=> __('site.survey.single')]))

@section('content')

    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <form method="post" action="{{ route('surveys.store') }}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="mb-3 d-flex flex-column justify-content-start">
                        <label for="title" class="form-label">{{ __('site.survey.field.title') }}</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <label for="description" class="form-label">{{ __('site.survey.field.description') }}</label>
                        <textarea id="description" name="description" rows="3"></textarea>
                        <label for="start_at" class="form-label">{{ __('site.survey.field.start_at') }}</label>
                        {{-- <input type="date" id="start_at" name="start_at" value="?php echo date('Y-m-d'); ?>" /> --}}
                        <input type="datetime-local" id="start_at" name="start_at" value="<?php echo date('Y-m-d H:i'); ?>" />
                        <label for="end_at" class="form-label">{{ __('site.survey.field.end_at') }}</label>
                        {{-- <input type="date" id="end_at" name="end_at" value="<php echo date( 'Y-m-d', strtotime( '+ 10 days' ) ); ?>" /> --}}
                        <input type="datetime-local" id="end_at" name="end_at" value="<?php echo date('Y-m-d H:i', strtotime('+ 10 days')); ?>" />
                        <label for="active" class="form-label">{{ __('site.survey.field.is_active') }}</label>
                        <input type="checkbox" id="active" name="active" class="btn-check" chekced />
                        <label class="btn btn-outline-success" for="active">{{ __('site.survey.field.active') }}</label>
                        <label for="image" class="form-label">{{ __('site.survey.field.image') }}</label>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('site.action.save') }}</button>

                </form>
                <div>
                    <a href="{{ route('surveys.index') }}" class="btn btn-light my-2">{{ __('site.action.return') }}</a>
                </div>

            </div>
        </div>


    </div>
    </div>
@endsection


@push('scripts')
@endpush

@push('head_styles')
@endpush
