@extends('layouts.myapp')

@section('page_title', __('site.vote.plural'))
@section('content')
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-dark" id="available-tab" data-bs-toggle="tab" data-bs-target="#available"
                    type="button" role="tab" aria-controls="available"
                    aria-selected="true">{{ __('site.survey.status.available') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="finished-tab" data-bs-toggle="tab" data-bs-target="#finished"
                    type="button" role="tab" aria-controls="finished"
                    aria-selected="false">{{ __('site.survey.status.finished') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                    type="button" role="tab" aria-controls="completed"
                    aria-selected="false">{{ __('site.survey.status.completed') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="results-tab" data-bs-toggle="tab" data-bs-target="#results"
                    type="button" role="tab" aria-controls="results"
                    aria-selected="false">{{ __('site.vote.results') }}</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="available" role="tabpanel" aria-labelledby="available-tab">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-hover table-dark table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('site.survey.field.image') }}</th>
                                    <th>{{ __('site.survey.field.title') }}</th>
                                    <th>{{ __('site.survey.field.started') }}</th>
                                    <th>{{ __('site.survey.field.ending') }}</th>
                                    <th>{{ __('site.vote.single') }}</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($available_surveys as $survey)
                                    <tr>
                                        <td>
                                            @if ($survey->image)
                                                <img src={{ Storage::disk('images')->url($survey->image->filename) }}
                                                    class="img-thumbnail" alt="survey-img" width="50px">
                                            @else
                                                <img src={{ Storage::disk('images')->url('no-image.jpg') }}
                                                    class="img-thumbnail" alt="survey-img" width="50px">
                                            @endif
                                        </td>
                                        <td>{{ $t->translate($survey->title, app()->getLocale()) }}</td>
                                        <td>{{ $survey->start_at->format('d.m.Y H:i') }}</td>
                                        <td>{{ $survey->end_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('voting.create', $survey) }}"
                                                class="btn btn-info  btn-sm">{{ __('site.vote.single') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-hover table-dark table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('site.survey.field.image') }}</th>
                                    <th>{{ __('site.survey.field.title') }}</th>
                                    <th>{{ __('site.survey.field.started') }}</th>
                                    <th>{{ __('site.survey.field.ended') }}</th>
                                    <th>{{ __('site.vote.is_voted') }}</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($finished_surveys as $survey)
                                    <tr>
                                        <td>
                                            @if ($survey->image)
                                                <img src={{ Storage::disk('images')->url($survey->image->filename) }}
                                                    class="img-thumbnail" alt="survey-img" width="50px">
                                            @else
                                                <img src={{ Storage::disk('images')->url('no-image.jpg') }}
                                                    class="img-thumbnail" alt="survey-img" width="50px">
                                            @endif
                                        </td>
                                        <td>{{ $t->translate($survey->title, app()->getLocale())  }}</td>
                                        <td>{{ $survey->start_at->format('d.m.Y H:i') }}</td>
                                        <td>{{ $survey->end_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @if (count($all_user_votes) > 0)
                                                @foreach ($all_user_votes as $vote)
                                                    @if ($vote->survey_id == $survey->id)
                                                        {{ __('site.vote.has_voted.yes') }}
                                                    @break

                                                @else
                                                    {{ __('site.vote.has_voted.no') }}
                                                @break
                                            @endif
                                        @endforeach
                                    @else
                                        {{ __('site.vote.has_voted.no') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
        <div class="row">
            <div class="col-md-12 text-center">
                <table class="table table-hover table-dark table-striped align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('site.survey.field.image') }}</th>
                            <th>{{ __('site.survey.field.title') }}</th>
                            <th>{{ __('site.survey.field.started') }}</th>
                            <th>{{ __('site.survey.field.ended') }}</th>
                            <th>{{ __('site.vote.your_vote') }}</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($completed_surveys as $survey)
                            <tr>
                                <td>
                                    @if ($survey->image)
                                        <img src={{ Storage::disk('images')->url($survey->image->filename) }}
                                            class="img-thumbnail" alt="survey-img" width="50px">
                                    @else
                                        <img src={{ Storage::disk('images')->url('no-image.jpg') }}
                                            class="img-thumbnail" alt="survey-img" width="50px">
                                    @endif
                                </td>
                                <td>{{ $t->translate($survey->title, app()->getLocale()) }}</td>
                                <td>{{ $survey->start_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $survey->end_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    {{-- {{ App\Models\Vote::where('user_id', Auth::id()).where('survey_id', $survey->id).get() }} --}}
                                    @if (count($all_user_votes) > 0)
                                        @foreach ($all_user_votes as $vote)
                                            @if ($vote->survey_id == $survey->id)
                                                @foreach ($all_options as $option)
                                                    @if ($option->id == $vote->response_option_id)
                                                        {{ $option->title }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @else
                                        {{ __('site.vote.has_voted.not_found') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">
        <div class="row">
            <div class="col-md-12 text-center">
                <table class="table table-hover table-dark table-striped align-middle">
                    <thead class="header-border">
                        <tr>
                            <th>{{ __('site.survey.field.image') }}</th>
                            <th>{{ __('site.survey.field.title') }}</th>
                            <th>{{ __('site.survey.field.start_at') }}</th>
                            <th>{{ __('site.survey.field.end_at') }}</th>
                            <th>{{ __('site.survey.field.active') }}</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($all_surveys as $survey)
                            <tr class="survey-data-row">
                                <td>
                                    <a href="{{ route('surveys.show', [$survey]) }}">
                                        @if ($survey->image)
                                            <img src={{ Storage::disk('images')->url($survey->image->filename) }}
                                                class="img-thumbnail" alt="survey-img" width="50px">
                                        @else
                                            <img src={{ Storage::disk('images')->url('no-image.jpg') }}
                                                class="img-thumbnail" alt="survey-img" width="50px">
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $t->translate($survey->title, app()->getLocale()) }}</td>
                                <td>{{ $survey->start_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $survey->end_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $survey->active ? 'Active' : 'Not Active' }}</td>
                            </tr>
                            <tr class="results-row">
                                <td colspan="5">
                                    <div class="d-flex flex-column flex-start">
                                        @foreach ($survey->options as $option)
                                            <a>{{ $option->title }}</a>
                                            <div class="progress db-dark">
                                                <div class="progress-bar progress-bar-striped" role="progressbar"
                                                    style="width: {{ $option->getVotePercentageAttribute('votePercentage') }}%"
                                                    aria-valuenow="{{ $option->getVotePercentageAttribute('votePercentage') }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $option->getVotePercentageAttribute('votePercentage') }}%
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>






</div>
@endsection


@push('scripts')
@endpush

@push('head_styles')
<style>
.progress {
    background-color: #505050;
    -webkit-box-shadow: none;
    box-shadow: none;
}

button .nav-link {
    color: black;
}

.results-row {
    border-bottom: 4px solid #582025;
    border-inline: 4px solid #203258;
}

.survey-data-row {
    border-top: 4px solid #203258;
    border-inline: 4px solid #203258;
}

.header-border {
    border: 4px solid #582025;
}
</style>
@endpush
