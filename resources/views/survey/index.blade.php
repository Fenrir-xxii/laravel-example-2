<?php
/**
 * @var \App\Models\Question[] $models
 * @var \App\Services\TranslatorService $t
 */
?>
@extends('layouts.myapp')

@section('page_title', __('site.survey.plural'))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{ __('site.survey.plural') }}</h1>
                <a href="{{ route('surveys.create') }}" class="btn btn-success my-2">{{ __('site.action.create') }}</a>
                <form class="d-flex py-2" method="GET">
                    <input class="form-control me-2" name="search" value="{{ $search }}" type="search"
                        placeholder="Search" aria-label="Search" id="search">
                    <button class="btn btn-light" type="submit">Search</button>
                </form>
                <table class="table table-hover table-dark table-striped align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('site.survey.field.image') }}</th>
                            <th>{{ __('site.survey.field.id') }}</th>
                            <th>{{ __('site.survey.field.title') }}</th>
                            <th>{{ __('site.survey.field.start_at') }}</th>
                            <th>{{ __('site.survey.field.end_at') }}</th>
                            <th>{{ __('site.survey.field.active') }}</th>
                            <th>{{ __('site.survey.field.controls') }}</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($models as $survey)
                            <tr>
                                <td>
                                    @if ($survey->image)
                                        <img src={{ Storage::disk('images')->url($survey->image->filename) }}
                                            class="img-thumbnail" alt="survey-img" width="50px">
                                    @else
                                        <img src={{ Storage::disk('images')->url('no-image.jpg') }} class="img-thumbnail"
                                            alt="survey-img" width="50px">
                                    @endif
                                </td>
                                <td>{{ $survey->id }}</td>
                                <td>{{ $t->translate($survey->title, app()->getLocale()) }}</td>
                                <td>{{ $survey->start_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $survey->end_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $survey->active ? __('site.survey.field.active') : __('site.survey.field.not_active') }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('surveys.edit', [$survey]) }}"
                                            class="btn btn-warning  btn-sm">{{ __('site.action.edit') }}</a>
                                        <a href="{{ route('options.index', [$survey]) }}"
                                            class="btn btn-info btn-sm">{{ __('site.action.options') }}</a>
                                        {{-- <a href="{{route('surveys.destroy', [$survey])}}" class="btn btn-danger">Delete</a> --}}
                                        <form method="post" action="{{ route('surveys.destroy', [$survey]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit"
                                                class="btn btn-danger btn-sm">{{ __('site.action.delete') }}</button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


        </div>
    </div>
@endsection


@push('scripts')
    <script>
        // var search = document.getElementById('search');
        // search.addEventListener('input', function() {
        //     this.form.submit();
        // }, false);
    </script>
@endpush

@push('head_styles')
@endpush
