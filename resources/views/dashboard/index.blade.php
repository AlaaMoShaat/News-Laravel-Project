@extends('layouts.dashboard.app')
@section('title')
    Home
@endsection
@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        @livewire('dashboard.statistics')

        <!-- Content Row -->

        {{-- chart row --}}
        <div class="row">

            <div class="card-body shadow col-6">
                <h4>{{ $posts_chart->options['chart_title'] }}</h4>
                {!! $posts_chart->renderHtml() !!}

            </div>
            <div class="card-body shadow col-6">
                <h4> {{ $users_chart->options['chart_title'] }} </h4>
                {!! $users_chart->renderHtml() !!}

            </div>
        </div>

        <!--Posts && Comments Row -->
        @livewire('dashboard.latest-posts-comments')


    </div>
@endsection

@push('js')
    {!! $posts_chart->renderChartJsLibrary() !!}

    {!! $posts_chart->renderJs() !!}
    {!! $users_chart->renderJs() !!}
@endpush
