@extends('layouts.myapp')

@section('page_title',  __('site.vote.voting.main'))

@section('content')

    <div class="container">

        <div class="row justify-content-md-center py-3">
            <div class="col-md-8">
                <form method="post" action="{{ route('voting.store') }}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="card text-center bg-dark text-light" style="width: 60vw;">
                        <div class="card-header">
                            {{ __('site.vote.voting.select_option') }}
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{ $survey->title }}</h3>
                            <p class="card-text">{{ $survey->description }}</p>
                            <table class="table table-hover table-dark table-striped align-middle">
                                <colgroup>
                                    <col span="1" style="width: 20%;">
                                    <col span="1" style="width: 80%;">
                                  </colgroup>
                                <tbody>
                                    @foreach ($options as $option)
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
                                            <td>
                                                <div class="form-check text-start">
                                                    <input class="form-check-input" type="radio" name="selected_option"
                                                        id="selected_option" value="{{$option->id}}">
                                                    <label class="form-check-label" for="selected_option">
                                                        {{ $option->title }}
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary" type="submit"> {{ __('site.vote.single') }}</button>
                            <a href="{{ route('voting.index') }}" class="btn btn-light my-2">{{ __('site.action.return') }}</a>
                        </div>
                    </div>

                </form>

            </div>


        </div>
    </div>
@endsection


@push('scripts')
@endpush

@push('head_styles')
    <style>
        ul {
            list-style-type: none !important;
        }
    </style>
@endpush
