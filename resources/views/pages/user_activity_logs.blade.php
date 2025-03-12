@extends('layouts.app')
@section('title') User Activity logs @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<script src="{{asset('assets/js/vendors/validation.js')}}"></script>

<main>
   <div class="container">
      <!-- row -->
      <div class="row mb-8 mt-10">
         <div class="col-md-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
               <!-- pageheader -->
               <div>
                  <h2>User Activity logs</h2>
                 
               </div>
               <!-- button -->
             
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12 col-12 mb-5">
            <!-- card -->
            <div class="card h-100 card-lg">
               <div class="px-6 py-6">
                  <div class="row justify-content-end">
                     {{-- <div class="col-lg-4 col-md-6 col-12 mb-2 mb-md-0">
                        <!-- form -->
                        <form class="d-flex" role="search">
                           <input class="form-control" type="search" placeholder="{{ __('globle.searchrole') }}" aria-label="Search" />
                        </form>
                     </div> --}}
                     <!-- select option -->
                     {{-- <button id="deleteSelected" class="btn btn-danger">Delete Selected</button> --}}
                     <div class="col-xl-2 col-md-4 col-12">
                        <select class="form-select" id="statusSelect">
                           <option selected>{{ __('globle.status') }}</option>
                           <option value="deleteSelected">{{ __('globle.deleteDelected') }}</option>
                        </select>
                     </div>
                  </div>
               </div>
               <!-- card body -->
               <div class="card-body p-0">
                  <!-- table -->
                  <div class="table-responsive">
                     <table id="dataTable" class="table table-centered table-hover mb-0 text-nowrap table-borderless table-with-checkbox">
                        <thead class="bg-light">
                           <tr>
                              <th>
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkAll" />
                                    <label class="form-check-label" for="checkAll"></label>
                                 </div>

                              </th>
                                    <th>No</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                    <th>Date & Time</th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($logs as $log)
                                 <tr>
                                    <td>
                                       <div class="form-check">
                                          <input class="form-check-input select-checkbox" type="checkbox" value="{{ $log->id }}" id="role_{{ $log->id }}" />
                                          <label class="form-check-label" for="role_{{ $log->id }}"></label>

                                       </div>
                                    </td>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->user_id }}</td>
                                    <td>{{ $log->username }}</td>
                                    <td>{{ $log->email }}</td>
                                    {{-- <td>{{ $log->role_id }}</td> --}}
                                    <td>{{ ucfirst($log->action) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d-n-Y g:i A') }}</td>
                                 </tr>
                           @endforeach

                        </tbody>
                     </table>
                  </div>
               </div>

         <script>

             $(document).ready(function(){

            //  =========== Use Option =========

               // Select or Deselect All Checkboxes
               $('#checkAll').on('click', function() {
                  $('.select-checkbox').prop('checked', this.checked);
               });

               // Handle select change event
               $('#statusSelect').on('change', function() {
                  var selectedOption = $(this).val();

                  if (selectedOption === 'deleteSelected') {
                        // Get all selected checkboxes
                        var selectedIds = [];
                        $('.select-checkbox:checked').each(function() {
                           selectedIds.push($(this).val());
                        });

                        // If no checkbox is selected, alert the user
                        if (selectedIds.length === 0) {
                           alert('Please select at least one item to delete.');
                           return;
                        }

                        // Confirm before deleting
                        if (!confirm('Are you sure you want to delete the selected items?')) {
                           $(this).val('Status'); // Reset the dropdown to default
                           return;
                        }

                        // Send an AJAX request to delete the selected roles
                        $.ajax({
                           url: "{{ route('user_log.deleteSelected') }}", // Laravel route for deleting roles
                           method: 'POST',
                           data: {
                              _token: "{{ csrf_token() }}",  // CSRF token
                              ids: selectedIds
                           },
                           success: function(response) {
                              // alert('Selected roles have been deleted successfully.');
                              location.reload(); // Reload the page to reflect changes
                           },
                           error: function(xhr) {
                              alert('Error occurred while deleting roles.');
                           }
                        });

                        // Reset the dropdown to default after deletion
                        $(this).val('Status'); // Reset the dropdown to default
                  }
               });


                 });
                 //  end Store

                  // Delete
                  // $('#dataTable').on('click', '.btnDelete',function(){
                  //   var current_row = $(this).closest('tr');
                  //   var id = current_row.find('td').eq(1).text();
                  //   var con = confirm("Are you sure to delete?");
                  //   if(con == true){
                  //       $.ajax({
                  //           url: "{{ route('role.delete') }}", // Your Laravel route to handle the form submission
                  //           method: "Delete",
                  //           data: {
                  //               _token: "{{ csrf_token() }}", // CSRF Token for security
                  //               id: id,
                  //           },
                  //           success: function(response) {
                  //                   // alert('Data Delete successfully!');
                  //                   // window.location.href = "{{ route('role.index') }}";
                  //                   location.reload();
                  //           },
                  //           error: function(response) {
                  //               alert('Error occurred!');
                  //           }
                  //       });
                  //   }

               //  });

         
         </script>



               <div class="border-top d-flex justify-content-between align-items-md-center px-6 py-6 flex-md-row flex-column gap-4">
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</main>

@endsection