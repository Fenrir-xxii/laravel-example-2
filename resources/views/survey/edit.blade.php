
@extends('layouts.myapp')

@section('page_title', __('site.action.edit_entity', ['entity'=> __('site.survey.single')]))

@section('content')

    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <h3>{{__('site.action.edit_entity', ['entity'=> __('site.survey.single')])}}</h3>
                <form method="post" action="{{ route('surveys.update', [$model]) }}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="mb-3 d-flex flex-column justify-content-start">
                        <label for="title" class="form-label">{{ __('site.survey.field.title') }}</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$t->translate($model->title, app()->getLocale()) }}">
                        <label for="description" class="form-label">{{ __('site.survey.field.description') }}</label>
                        <textarea id="description" name="description" rows="3">{{ $t->translate($model->description, app()->getLocale()) }}</textarea>
                        <label for="start_at" class="form-label">{{ __('site.survey.field.start_at') }}</label>
                        {{-- <input type="date" id="start_at" name="start_at" value="?php echo $model->start_at->format('Y-m-d'); ?>" /> --}}
                        <input type="datetime-local" id="start_at" name="start_at" value="{{ $model->start_at }}" />
                        <label for="end_at" class="form-label">{{ __('site.survey.field.end_at') }}</label>
                        {{-- <input type="date" id="end_at" name="end_at" value="?php echo $model->end_at->format('Y-m-d'); ?>" /> --}}
                        <input type="datetime-local" id="end_at" name="end_at" value="{{ $model->end_at }}" />
                        <label for="active" class="form-label">{{ __('site.survey.field.is_active') }}</label>
                        <input type="checkbox" id="active" name="active" class="btn-check" <?php if ($model->active) {
                            echo 'checked';
                        } ?> />
                        <label class="btn btn-outline-success" for="active">{{ __('site.survey.field.active') }}</label>
                        <label for="image" class="form-label">{{ __('site.survey.field.image') }}</label>
                        @if ($model->image)
                            <img src={{ Storage::disk('images')->url($model->image->filename) }} class="img-thumbnail"
                                alt="survey" width="150px">
                        @endif
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg, .jpg">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('site.action.save') }}</button>
                    {{-- <a href="{{ route('surveys.index') }}" class="btn btn-light my-2">Return</a> --}}
                </form>
                <div>
                    <table class="table table-hover table-dark table-striped align-middle">
                        <caption>
                            {{ __('site.table.list_of_options') }}
                        </caption>
                        <thead>
                            <tr>
                                <th>{{ __('site.survey.field.image') }}</th>
                                <th>{{ __('site.survey.field.title') }}</th>
                                <th>{{ __('site.survey.field.controls') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model->options as $option)
                                <tr>
                                    <td>
                                        @if ($option->image)
                                            <img src={{ Storage::disk('images')->url($option->image->filename) }}
                                                class="img-thumbnail" alt="survey-img" width="50px">
                                        @else
                                            <img src={{ Storage::disk('images')->url('no-image.jpg') }}
                                                class="img-thumbnail" alt="survey-img" width="50px">
                                        @endif
                                    </td>
                                    <td>{{ $t->translate($option->title, app()->getLocale()) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('options.edit', [$option]) }}"
                                                class="btn btn-warning btn-sm">{{ __('site.action.edit') }}</a>
                                            <form method="post" action="{{ route('options.destroy', [$model]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm">{{ __('site.action.delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('options.create', [$model]) }}" class="btn btn-success my-2">{{__('site.action.add_entity', ['entity'=> __('site.option.single')])}}</a>
                    <a href="{{ route('surveys.index') }}" class="btn btn-light my-2">{{__('site.action.return')}}</a>
                </div>

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
