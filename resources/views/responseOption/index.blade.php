@extends('layouts.myapp')

@section('page_title', __('site.option.plural'))

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>{{__('site.survey.single')}}: {{ $survey->title }}</h3>
                <a href="{{route('options.create', [$survey])}}" class="btn btn-success my-2">{{__('site.action.create_entity', ['entity'=> __('site.option.single')])}}</a>
                <a href="{{route('surveys.index')}}" class="btn btn-light my-2">{{__('site.action.return')}}</a>
                <table class="table table-hover table-dark table-striped align-middle">
                    <caption>
                        {{__('site.table.list_of_options')}}
                    </caption>
                    <thead>
                        <tr>
                            <th>{{__('site.option.field.image')}}</th>
                            <th>{{__('site.option.field.id')}}</th>
                            <th>{{__('site.option.field.title')}}</th>
                            <th>{{__('site.option.field.controls')}}</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($options as $option)
                            <tr>
                                <td>
                                    @if ($option->image)
                                        <img src={{ Storage::disk('images')->url($option->image->filename) }}
                                            class="img-thumbnail" alt="survey-img" width="50px">
                                    @else
                                        <img src={{ Storage::disk('images')->url('no-image.jpg') }} class="img-thumbnail"
                                            alt="survey-img" width="50px">
                                    @endif
                                </td>
                                <td>{{ $option->id }}</td>
                                <td>{{ $t->translate($option->title, app()->getLocale()) }}</td>
                                <td>
                                    <div class="d-flex gap-2 align-middle justify-content-center">
                                        <a href="{{ route('options.edit', [$option]) }}" class="btn btn-warning btn-sm">{{__('site.action.edit')}}</a>
                                        {{-- <a href="#" class="btn btn-danger btn-sm">Delete</a> --}}
                                        <form method="post" action="{{ route('options.destroy', [$survey]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">{{__('site.action.delete')}}</button>
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
@endpush

@push('head_styles')
    <style>
        caption {
            padding: 10px;
            caption-side: top;
            font-size: 20px;
        }
    </style>
@endpush
