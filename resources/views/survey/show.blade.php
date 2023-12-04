@extends('layouts.myapp')

@section('page_title', __('site.survey.results.main'))

@section('content')

    <div class="container">

        <div class="row justify-content-md-center py-3">
            <div class="card bg-dark text-light" style="width: 35rem;">

                <div class="container-sm text-center">
                    @if ($model->image)
                        <img src={{ Storage::disk('images')->url($model->image->filename) }} class="card-img-top"
                            alt="survey-img">
                    @else
                        <img src={{ Storage::disk('images')->url('no-image.jpg') }} class="card-img-top" alt="survey-img">
                    @endif
                </div>

                {{-- <img src="{{ Storage::disk('images')->url($model->image->filename) }}" class="card-img-top"
                    alt="survey-img"> --}}
                <div class="card-body">
                    <h5 class="card-title"><b>{{ __('site.survey.results.title') }}</b> {{ $t->translate($model->title, app()->getLocale()) }}</h5>
                    <p class="card-text"><b>{{ __('site.survey.results.description') }}</b> {{ $t->translate($model->description, app()->getLocale()) }}</p>
                </div>
                <ul class="list-group list-group-flush bg-dark">
                    <li class="list-group-item bg-dark text-light"><b>{{ __('site.survey.results.start') }}</b>
                        {{ $model->start_at }}</li>
                    <li class="list-group-item bg-dark text-light"><b>{{ __('site.survey.results.end') }}</b> {{ $model->end_at }}
                    </li>
                    <li class="list-group-item bg-dark text-light"><b>{{ __('site.survey.results.status') }}</b>
                        {{ $model->active ? __('site.survey.results.status_active') : __('site.survey.results.status_not_active') }}
                    </li>
                    <li class="list-group-item bg-dark text-light"><b>{{ __('site.survey.results.votes') }}</b>
                        @php
                            $voteCount = 0;
                        @endphp
                        @foreach ($model->options as $option)
                            
                            @if ($option->votes !== null)
                                @php $voteCount += count($option->votes) @endphp
                            @endif
                        @endforeach
                        {{ $voteCount }}

                    </li>
                </ul>
                <div class="chart-container" style="width: 250px; margin: auto;">
                    <canvas id="myChart"></canvas>
                </div>
                <a href="{{ route('voting.index') }}" class="btn btn-light my-2">{{ __('site.action.return') }}</a>
            </div>


        </div>
    </div>
@endsection


@push('scripts')
    <script>
        let dataArr = @json($model->options);
        let labelArr = @json($labels);

        // console.log(labelArr);
        labelData = [];
        valueData = [];
        dataArr.forEach((element) => {
            // labelData.push(element.title);
            valueData.push(element.votes.length);
        });
        labelArr.forEach((element) => {
            labelData.push(element);
        });
        console.log(labelData);
        console.log(valueData);
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labelData,
                datasets: [{
                    label: 'My First Dataset',
                    data: valueData,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
@endpush

@push('head_styles')
    <style>
        .container-sm{
            max-width: 250px;
            padding-top: 5px;
        }
        .chart-container{
            padding-block: 7px;
        }
    </style>
@endpush
