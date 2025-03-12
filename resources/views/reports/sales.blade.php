@extends('layouts.app')
@section('title') Sales - Report @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12 mt-4">
            <h2>Sales Report</h2>
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

    <div id="sales-report" class="mt-3 mb-5">
        <!-- Sales report data will be loaded here -->
        <!-- Initially, we will load all sales data if available -->
        @include('reports.sales_report', ['sales' => $sales, 'totalSales' => $totalSales, 'totalItemsSold' => $totalItemsSold])
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#filter-button').on('click', function (e) {
        e.preventDefault(); // Prevent form submission

        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();

        // Clear previous content
        $('#sales-report').html('');
        $('#error-message').html('');

        // Validate input
        if (!start_date || !end_date) {
            $('#error-message').html('<div class="alert alert-danger">Please select both start and end dates.</div>');
            return;
        }

        // AJAX request to fetch filtered data
        $.ajax({
            url: "{{ route('reports.sales') }}", // Ensure this route is correct
            method: "GET",
            data: { start_date: start_date, end_date: end_date },
            beforeSend: function () {
                $('#filter-button').text('Filtering...').attr('disabled', true); // Disable the button
            },
            success: function (response) {
                if (response.html) {
                    $('#sales-report').html(response.html);
                } else {
                    $('#sales-report').html('<div class="alert alert-info">No sales data found for this period.</div>');
                }
            },
            error: function (xhr) {
                // Show detailed error message
                console.error('Error:', xhr.responseText); // Log the response in console for debugging
                $('#error-message').html('<div class="alert alert-danger">An error occurred while fetching the data. Please try again. ' + xhr.responseText + '</div>');
            },
            complete: function () {
                $('#filter-button').text('Filter').attr('disabled', false); // Re-enable the button
            }
        });
    })
    });
</script>
