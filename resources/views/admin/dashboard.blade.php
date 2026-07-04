@extends('layouts.main')

@section('title', 'Home')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Home')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')
    <div class="row">
        @php
            $statItems = [
                'Tours' => ['tours', 'bg-primary'],
                'Activities' => ['activities', 'bg-success'],
                'Trekkings' => ['trekkings', 'bg-warning'],
                'Blog Posts' => ['posts', 'bg-danger'],
                'Special Offers' => ['offers', 'bg-info'],
                'Locations' => ['locations', 'bg-secondary'],
            ];
        @endphp


        @foreach ($statItems as $label => [$key, $class])
            <div class="col-md-4 col-sm-6">
                <div
                    class="card statistics-card-1 overflow-hidden {{ Str::contains($class, 'text-white') ? 'text-white' : '' }}">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/img-status-4.svg') }}" alt="{{ $label }}"
                            class="img-fluid img-bg" />
                        <h5 class="mb-4 {{ Str::contains($class, 'text-white') ? 'text-white' : '' }}">{{ $label }}
                        </h5>
                        <div class="d-flex align-items-center mt-3">
                            <h3 class="f-w-300 m-b-0 {{ Str::contains($class, 'text-white') ? 'text-white' : '' }}">
                                {{ $stats[$key] ?? 0 }}
                            </h3>
                        </div>
                        <p
                            class="text-sm mt-3 {{ Str::contains($class, 'text-white') ? 'text-white text-opacity-75' : 'text-muted mb-2' }}">
                            {{ $label }} in system
                        </p>
                        <div class="progress {{ Str::contains($class, 'text-white') ? 'bg-white bg-opacity-10' : '' }}"
                            style="height: 7px">
                            <div class="progress-bar {{ $class }}" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Entity Distribution (Bar)</h5>
                </div>
                <div class="card-body">
                    <div id="barChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Entity Distribution (Donut)</h5>
                </div>
                <div class="card-body">
                    <div id="donutChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('build/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('build/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('build/js/plugins/world.js') }}"></script>
    <script src="{{ asset('build/js/plugins/world-merc.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stats = @json($stats);

            const labels = ['Tours', 'Activities', 'Trekkings', 'Posts', 'Users', 'Locations', 'Active Offers'];
            const values = [
                stats.tours ?? 0,
                stats.activities ?? 0,
                stats.trekkings ?? 0,
                stats.posts ?? 0,
                stats.users ?? 0,
                stats.locations ?? 0,
                stats.offers ?? 0,
            ];

            new ApexCharts(document.querySelector("#barChart"), {
                chart: {
                    type: 'bar',
                    height: 300
                },
                series: [{
                    name: 'Count',
                    data: values
                }],
                xaxis: {
                    categories: labels
                },
                colors: ['#2C7BE5']
            }).render();

            new ApexCharts(document.querySelector("#donutChart"), {
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: labels,
                series: values,
                colors: ['#2C7BE5', '#00D97E', '#F6C343', '#E63757', '#6C757D', '#8C9EFF', '#9A4DFF']
            }).render();
        });
    </script>
@endsection
