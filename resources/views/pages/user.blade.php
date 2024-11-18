@extends('layouts.app')
@section('title') USER - BOOKLE @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<script src="{{asset('assets/js/vendors/validation.js')}}"></script>

<main >
   <div class="container">
      <!-- row -->
      <div class="row mb-8 mt-10">
         <div class="col-md-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
               <!-- pageheader -->
               <div>
                  <h2>{{ __('globle.user') }}</h2>
                 
               </div>
               <!-- button -->
               <div>
                  <a href="#" id="btnmodal" class="btn btn-primary">{{ __('globle.adduser') }}</a>
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
                           <input class="form-control" type="search" placeholder="{{ __('globle.searchUser') }}" aria-label="Search" />
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
                              <th>{{ __('globle.profile') }}</th>
                              <th>{{ __('globle.name') }}</th>
                              <th>{{ __('globle.emal') }}</th>
                              <th>{{ __('globle.role') }}</th>
                              <th>{{ __('globle.action') }}Action</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($users as $user)
                                 <tr>
                                    <td>
                                       <div class="form-check">
                                          <input class="form-check-input select-checkbox" type="checkbox" value="{{ $user->id }}" id="role_{{ $user->id }}" />
                                          <label class="form-check-label" for="role_{{ $user->id }}"></label>

                                       </div>
                                    </td>
                              
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                       <a href="#!"><img src="{{ Storage::url($user->profile) }}" alt="" class="icon-shape icon-md" /></a>
                                    </td>

                                   <td>{{ $user->name }}</td>
                                   <td>{{ $user->email }}</td>
                                   <td data-role-id="{{ $user->role_id }}">{{ $user->role ? $user->role->{'name_' . app()->getLocale()} : 'No Role Assigned' }}</td>


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
                                                <a class="dropdown-item btnEdit" href="#" data-id="{{ $user->id }}">
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

               <!-- Modal Insert-->
               <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-body">
                              <form id="formSave" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  <!-- Hidden input to differentiate between insert and update -->
                                  <input type="hidden" name="_method" id="formMethod" value="POST">
                                  <input type="text" hidden class="form-control" id="id" name="id">
              
                                  <div class="row">
                                      <div class="col-lg-6">
                                          <div class="mb-3">
                                              <label for="name" class="form-label">Name</label>
                                              <input type="text" class="form-control" id="name" name="name">
                                          </div>
                                      </div>
              
                                      <div class="col-lg-6">
                                          <div class="mb-3">
                                              <label for="email" class="form-label">Email</label>
                                              <input type="text" class="form-control" id="email" name="email">
                                          </div>
                                      </div>
                                  </div>
              
                                  <div class="mb-3" id="editpass">
                                      <label for="password" class="form-label">Password</label>
                                      <input type="text" class="form-control" id="password" name="password">
                                  </div>
              
                                  <div class="mb-3">
                                      <label class="form-label">Role</label>
                                      <select class="form-select" id="role_id" name="role_id">
                                          @foreach($roles as $role)
                                          <option value="{{ $role->id }}">{{ $role->name_en }}</option>
                                          @endforeach
                                      </select>
                                  </div>
              
                                  <label class="form-label">Profile</label>
                                  <div class="mb-4 d-flex">
                                      <div class="position-relative">
                                          <img class="image icon-shape icon-xxxl bg-light rounded-4" src="../assets/images/icons/user-profile.svg" alt="Image" />
                                          <div class="file-upload position-absolute end-0 top-0 mt-n2 me-n1">
                                              <input type="file" id="profile" name="profile" class="file-input" />
                                              <span class="icon-shape icon-sm rounded-circle bg-white">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-pencil-fill text-muted" viewBox="0 0 16 16">
                                                      <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                  </svg>
                                              </span>
                                          </div>
                                      </div>
                                  </div>
              
                                  <!-- Dynamic Save/Update Button -->
                                  <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
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
                           url: "{{ route('user.deleteSelected') }}", // Laravel route for deleting roles
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


               // -------------------
                  
                // Modal
                $('#btnmodal').click(function(){
                    $('#modalForm').modal('show');
                    $('#btnUpdate').hide();
                });

                $('#btnSave').on('click', function() {
                        var formData = new FormData($('#formSave')[0]);
                        var id = $('#id').val(); // If this exists, it's an update

                        var url = id ? '/user/update/' + id : '/user/store'; // Update if id exists, otherwise insert
                        var method = id ? 'PUT' : 'POST'; // PUT for update, POST for insert

                        // Append the spoofed method if it's an update
                        if (id) {
                           formData.append('_method', 'PUT'); // Method spoofing for PUT
                        }

                        $.ajax({
                           url: url,
                           type: 'POST', // Always POST, we spoof PUT when needed
                           data: formData,
                           contentType: false,
                           processData: false,
                           headers: {
                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function(response) {
                                 $('#modalForm').modal('hide');
                                 // window.location.href = "{{ route('user.index') }}";
                                 location.reload();
                           },
                           error: function(xhr) {
                                 console.log(xhr.responseText); // Handle error
                           }
                        });
                     });

                     // Load data into modal for update
                     $(document).on('click', '.btnEdit', function() {
                        var id = $(this).data('id');
                        $('#editpass').hide();
                        // Fetch data for user and populate form
                        $.ajax({
                           url: '/user/edit/' + id,
                           type: 'GET',
                           success: function(data) {
                                 $('#id').val(data.id);
                                 $('#name').val(data.name);
                                 $('#email').val(data.email);
                                 $('#role_id').val(data.role_id);
                                 $('#password').val(''); // Clear password field
                                 $('#profile').val('');  // Clear file input
                                 $('#btnSave').text('Update'); // Change button text
                                 $('#modalForm').modal('show');
                           }
                        });
                     });

                     // Reset form for insert
                     $('#addUser').on('click', function() {
                        $('#formSave')[0].reset(); // Clear form
                        $('#id').val(''); // Clear ID field
                        $('#btnSave').text('Save'); // Change button text to Save
                        $('#modalForm').modal('show');
                     });

                 

                  // Delete
                  $('#dataTable').on('click', '.btnDelete',function(){
                    var current_row = $(this).closest('tr');
                    var id = current_row.find('td').eq(1).text();
                    var con = confirm("Are you sure to delete?");
                    if(con == true){
                        $.ajax({
                            url: "{{ route('user.delete') }}", // Your Laravel route to handle the form submission
                            method: "Delete",
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token for security
                                id: id,
                            },
                            success: function(response) {
                                    // alert('Data Delete successfully!');
                                    // window.location.href = "{{ route('user.index') }}";
                                    location.reload();
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