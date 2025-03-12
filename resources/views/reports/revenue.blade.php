@extends('layouts.app')
@section('title') Revenue - Report @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Daily Revenue Report</h2>
    <canvas id="revenueChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($days), // Date Labels
            datasets: [{
                label: 'Daily Revenue ($)',
                data: @json($revenues), // Revenue Data
                borderColor: 'green',
                backgroundColor: 'rgba(0, 255, 0, 0.2)',
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: 'green'
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'category', // Display as categories (Dates)
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value; // Format Y-axis as Currency
                        }
                    }
                }
            }
        }
    });
</script>


{{-- <script>
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($revenues),
                borderColor: 'green',
                backgroundColor: 'rgba(0, 255, 0, 0.2)',
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: 'green'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
</script> --}}

@endsection
