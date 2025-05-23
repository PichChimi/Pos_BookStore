@extends('layouts.app')
@section('title') AUTHORS - BOOKLE @endsection
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
                  <h2>{{ __('globle.authors') }}</h2>
                 
               </div>
               <!-- button -->
               <div>
                  <a href="#" id="btnmodal" class="btn btn-primary">{{ __('globle.addauthore') }}</a>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12 col-12 mb-5">
            <!-- card -->
            <div class="card h-100 card-lg">
               <div class="px-6 py-6">
                  <div class="row justify-content-between">
                     <div class="col-lg-4 col-md-6 col-12 mb-2 mb-md-0">
                        <!-- form -->
                        <form class="d-flex" role="search">
                           <input class="form-control" type="search" placeholder="{{ __('globle.searchauthors') }}" aria-label="Search" />
                        </form>
                     </div>
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
                              <th>{{ __('globle.no') }}</th>
                              <th>{{ __('globle.name') }}</th>
                              <th>{{ __('globle.nationality') }}</th>
                              <th>{{ __('globle.action') }}</th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($authors as $author)
                                 <tr>
                                    <td>
                                       <div class="form-check">
                                          <input class="form-check-input select-checkbox" type="checkbox" value="{{ $author->id }}" id="role_{{ $author->id }}" />
                                          <label class="form-check-label" for="role_{{ $author->id }}"></label>

                                       </div>
                                    </td>
                              
                                    <td>{{ $author->id }}</td>

                                    <td data-name-en="{{ $author->name_en }}" data-name-kh="{{ $author->name_kh }}">
                                       {{ $author->{'name_' . app()->getLocale()} }}
                                    </td>

                                    <td data-nationality-en="{{ $author->nationality_en }}" data-nationality-kh="{{ $author->nationality_kh }}">
                                       {{ $author->{'nationality_' . app()->getLocale()} }}
                                    </td>

                                    <td>
                                       <div class="dropdown">
                                          <a href="#" class="text-reset" data-bs-toggle="dropdown" aria-expanded="false">
                                             <i class="feather-icon icon-more-vertical fs-5"></i>
                                          </a>
                                          <ul class="dropdown-menu">
                                             <li>
                                                <a class="dropdown-item btnDelete" href="#">
                                                   <i class="bi bi-trash me-3 text-danger"></i>
                                                   <span class="text-danger">{{ __('globle.delete') }}</span>
                                                </a>
                                             </li>
                                             <li>
                                                <a class="dropdown-item btnEdit" href="#">
                                                   <i class="bi bi-pencil-square me-3"></i>
                                                   {{ __('globle.edit') }}
                                                </a>
                                             </li>
                                          </ul>
                                       </div>
                                    </td>
                                 </tr>
                           @endforeach

                        </tbody>
                     </table>
                  </div>
               </div>

               <!-- Modal -->
         <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-body">
                  
                  <form id="formSave">
                        
                        <div class="mb-3">
                        
                        <input type="text" hidden class="form-control" id="id" >
                        </div>

                        <div class="mb-3">
                        <label for="name_en" class="form-label">{{ __('globle.namen') }}</label>
                        <input type="text" class="form-control" id="name_en" >
                        </div>

                        <div class="mb-3">
                        <label for="name_kh" class="form-label">{{ __('globle.namekh') }}</label>
                        <input type="text" class="form-control" id="name_kh" >
                        </div>

                        <div class="mb-3">
                        <label for="nationality_en" class="form-label">{{ __('globle.na_en') }}</label>
                        <input type="text" class="form-control" id="nationality_en" >
                        </div>

                        <div class="mb-3">
                        <label for="nationality_kh" class="form-label">{{ __('globle.na_kh') }}</label>
                        <input type="text" class="form-control" id="nationality_kh" >
                        </div>

                        <button type="submit" id="btnSave" class="btn btn-primary">{{ __('globle.save') }}</button>
                        <a href="#" id="btnUpdate" class="btn btn-primary">{{ __('globle.edit') }}</a>
                     
                  </form>

               </div>
            </div>
            </div>
         </div>

         <!-- end Modal -->
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
                           url: "{{ route('author.deleteSelected') }}", // Laravel route for deleting roles
                           method: 'POST',
                           data: {
                              _token: "{{ csrf_token() }}",  // CSRF token
                              ids: selectedIds
                           },
                           success: function(response) {
                              Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Authors has been deleted successfully.',
                                    timer: 2000, // Modal will auto-close after 2 seconds
                                    showConfirmButton: false // Hides the "OK" button
                              }).then(() => {
                                    location.reload(); // Reload the page after the modal closes
                              });
                           },
                           error: function(xhr) {
                              alert('Error occurred while deleting roles.');
                           }
                        });

                        // Reset the dropdown to default after deletion
                        $(this).val('Status'); // Reset the dropdown to default
                  }
               });


               // -------------------
                  
                // Modal
                $('#btnmodal').click(function(){
                    $('#modalForm').modal('show');
                    $('#btnUpdate').hide();
                });

                 //   Insert data
                 $('#formSave').on('submit', function(e){
                    e.preventDefault();
                    var name_en = $('#name_en').val();
                    var name_kh = $('#name_kh').val();
                    var nationality_en = $('#nationality_en').val();
                    var nationality_kh = $('#nationality_kh').val();

                     $.ajax({
                     url: "{{ route('author.store') }}", // Your Laravel route to handle the form submission
                     method: "POST",
                     data: {
                           _token: "{{ csrf_token() }}", // CSRF Token for security
                           name_en: name_en,
                           name_kh: name_kh,
                           nationality_en: nationality_en,
                           nationality_kh: nationality_kh
                     },
                     success: function(response) {
                          $('#modalForm').modal('hide');
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Authors has been inserted successfully.',
                                    timer: 2000, // Modal will auto-close after 2 seconds
                                    showConfirmButton: false // Hides the "OK" button
                              }).then(() => {
                                    location.reload(); // Reload the page after the modal closes
                              });
                     },
                     error: function(response) {
                           alert('Error occurred!');
                     }
                  });

                 });
                 //  end Store

                  //  Edit
                  $('#dataTable').on('click', '.btnEdit', function(){
                     var current_row = $(this).closest('tr');
                     var id = current_row.find('td').eq(1).text();
                     var name_en = current_row.find('td').eq(2).data('name-en'); // Get 'name_en'
                     var name_kh = current_row.find('td').eq(2).data('name-kh'); // Get 'name_kh'
                     var nationality_en = current_row.find('td').eq(3).data('nationality-en'); // Get 'name_en'
                     var nationality_kh = current_row.find('td').eq(3).data('nationality-kh'); // Get 'name_kh'
                     
                     $('#id').val(id);
                    $('#name_en').val(name_en);
                    $('#name_kh').val(name_kh);
                    $('#nationality_en').val(nationality_en);
                    $('#nationality_kh').val(nationality_kh);

                    $('#modalForm').modal('show');
                    $('#btnSave').hide();

                    $('#btnUpdate').click(function(){
                        var id = $('#id').val();
                        var name_en = $('#name_en').val();
                        var name_kh = $('#name_kh').val();
                        var nationality_en = $('#nationality_en').val();
                        var nationality_kh = $('#nationality_kh').val();

                        $.ajax({
                            url: "{{ route('author.update') }}", // Your Laravel route to handle the form submission
                            method: "PUT",
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token for security
                                id: id,
                                name_en: name_en,
                                name_kh: name_kh,
                                nationality_en: nationality_en,
                                nationality_kh: nationality_kh
                            },
                            success: function(response) {
                              $('#modalForm').modal('hide');
                              Swal.fire({
                                       icon: 'success',
                                       title: 'Success!',
                                       text: 'Authors has been updated successfully.',
                                       timer: 2000, // Modal will auto-close after 2 seconds
                                       showConfirmButton: false // Hides the "OK" button
                                 }).then(() => {
                                       location.reload(); // Reload the page after the modal closes
                                 });
                            },
                            error: function(response) {
                                alert('Error occurred!');
                            }
                        });

                    });
                    
                  
                  });
                  //  end Edit

                  // Delete
                  $('#dataTable').on('click', '.btnDelete',function(){
                    var current_row = $(this).closest('tr');
                    var id = current_row.find('td').eq(1).text();
                    var con = confirm("Are you sure to delete?");
                    if(con == true){
                        $.ajax({
                            url: "{{ route('author.delete') }}", // Your Laravel route to handle the form submission
                            method: "Delete",
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token for security
                                id: id,
                            },
                            success: function(response) {
                              Swal.fire({
                                       icon: 'success',
                                       title: 'Success!',
                                       text: 'Authors has been deleted successfully.',
                                       timer: 2000, // Modal will auto-close after 2 seconds
                                       showConfirmButton: false // Hides the "OK" button
                                 }).then(() => {
                                       location.reload(); // Reload the page after the modal closes
                                 });
                            },
                            error: function(response) {
                                alert('Error occurred!');
                            }
                        });
                    }

                });

              });

         </script>



               <div class="border-top d-flex justify-content-between align-items-md-center px-6 py-6 flex-md-row flex-column gap-4">
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</main>

@endsection