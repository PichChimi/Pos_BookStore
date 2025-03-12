@extends('layouts.app')
@section('title') Employee - Report @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="container">
    <div class="row mb-3 mt-3">
        <div class="col-md-12">
            <h2>Employee Report</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form id="sales-filter-form" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-4 mt-4">
                        <button type="button" id="filter-button" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="error-message" class="mt-3"></div>

    <div id="employee-report" class="mt-3">
        <!-- Sales report data will be loaded here -->
        @include('reports.employee_report', ['sales' => $sales, 'grandTotalSales' => $grandTotalSales, 'grandTotalItems' => $grandTotalItems])
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#filter-button').on('click', function (e) {
            e.preventDefault();

            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            $('#employee-report').html('');
            $('#error-message').html('');

            if (!start_date || !end_date) {
                $('#error-message').html('<div class="alert alert-danger">Please select both start and end dates.</div>');
                return;
            }

            $.ajax({
                url: "{{ route('reports.employeeSales') }}",
                method: "GET",
                data: { start_date, end_date },
                beforeSend: function () {
                    $('#filter-button').text('Filtering...').attr('disabled', true);
                },
                success: function (response) {
                    if (response.html) {
                        $('#employee-report').html(response.html);
                    } else {
                        $('#employee-report').html('<div class="alert alert-info">No sales data found for this period.</div>');
                    }
                },
                error: function (xhr) {
                    $('#error-message').html('<div class="alert alert-danger">An error occurred while fetching the data. Please try again.</div>');
                },
                complete: function () {
                    $('#filter-button').text('Filter').attr('disabled', false);
                }
            });
        })
    });
</script>
