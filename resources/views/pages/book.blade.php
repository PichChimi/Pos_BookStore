@extends('layouts.app')
@section('title') BOOK - BOOKLE @endsection
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
                  <h2>Book</h2>
                 
               </div>
               <!-- button -->
               <div>
                  <a href="#" id="btnmodal" class="btn btn-primary">Add New Book</a>
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
                           <input class="form-control" type="search" placeholder="Search Category" aria-label="Search" />
                        </form>
                     </div>
                     <!-- select option -->
                     {{-- <button id="deleteSelected" class="btn btn-danger">Delete Selected</button> --}}
                     <div class="col-xl-2 col-md-4 col-12">
                        <select class="form-select" id="statusSelect">
                           <option selected>Status</option>
                           <option value="deleteSelected">Delete Selected</option>
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
                              <th>Cover Book</th>
                              <th>Title</th>
                              <th>Qty</th>
                              <th>Price</th>
                              <th>Genres</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($books as $book)
                               @foreach ($book->stocks as $stock)
                                 <tr>
                                    <td>
                                       <div class="form-check">
                                          <input class="form-check-input select-checkbox" type="checkbox" value="{{ $book->id }}" id="role_{{ $book->id }}" />
                                          <label class="form-check-label" for="role_{{ $book->id }}"></label>

                                       </div>
                                    </td>
                              
                                    {{-- <td>{{ $book->id }}</td> --}}
                                    <td>{{ $loop->parent->iteration }}</td>
                                    <td>
                                       <a href="#!"><img src="{{ Storage::url($book->cover_book) }}" alt="" class="icon-shape icon-md" /></a>
                                    </td>

                                    <td data-title-en="{{ $book->title_en }}" data-title-kh="{{ $book->title_en }}">
                                       {{ $book->{'title_' . app()->getLocale()} }}
                                    </td>

                                   <td>{{ $stock->quantity }}</td>
                                   <td>${{ $stock->selling_price }}</td>
                                   <td data-genres-id="{{ $book->genres_id }}">{{ $book->genres ? $book->genres->{'name_' . app()->getLocale()} : 'No Genres Assigned' }}</td>


                                    <td>
                                       <div class="dropdown">
                                          <a href="#" class="text-reset" data-bs-toggle="dropdown" aria-expanded="false">
                                             <i class="feather-icon icon-more-vertical fs-5"></i>
                                          </a>
                                          <ul class="dropdown-menu">
                                             <li>
                                                <a class="dropdown-item btnDelete" href="#">
                                                   <i class="bi bi-trash me-3 text-danger"></i>
                                                   <span class="text-danger">Delete</span>
                                                </a>
                                             </li>
                                             <li>
                                                <a class="dropdown-item btnEdit" href="#" data-id="{{ $book->id }}">
                                                   <i class="bi bi-pencil-square me-3"></i>
                                                   Edit
                                                </a>
                                             </li>
                                          </ul>
                                       </div>
                                    </td>
                                 </tr>
                              @endforeach
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
                                              <label for="title_en" class="form-label">Title English</label>
                                              <input type="text" class="form-control" id="title_en" name="title_en">
                                          </div>

                                          <div class="mb-3">
                                             <label class="form-label">Authore</label>
                                             <select class="form-select" id="authors_id" name="authors_id">
                                                 @foreach($authorses as $authors)
                                                 <option value="{{ $authors->id }}">{{ $authors->name_en }}</option>
                                                 @endforeach
                                             </select>
                                         </div>

                                         <label class="form-label">Cover Book</label>
                                          <div class="mb-4 d-flex">
                                             <div class="position-relative">
                                                   <img class="image icon-shape icon-xxxl bg-light rounded-4" src="../assets/images/icons/book-closed.svg" alt="Image" />
                                                   <div class="file-upload position-absolute end-0 top-0 mt-n2 me-n1">
                                                      <input type="file" id="cover_book" name="cover_book" class="file-input" />
                                                      <span class="icon-shape icon-sm rounded-circle bg-white">
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-pencil-fill text-muted" viewBox="0 0 16 16">
                                                               <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                         </svg>
                                                      </span>
                                                   </div>
                                             </div>
                                          </div>

                                      </div>
              
                                      <div class="col-lg-6">

                                          <div class="mb-3">
                                              <label for="title_kh" class="form-label">Title Khmer</label>
                                              <input type="text" class="form-control" id="title_kh" name="title_kh">
                                          </div>

                                          <div class="mb-3">
                                             <label class="form-label">Genres</label>
                                             <select class="form-select" id="genres_id" name="genres_id">
                                                 @foreach($genreses as $genres)
                                                 <option value="{{ $genres->id }}">{{ $genres->name_en }}</option>
                                                 @endforeach
                                             </select>
                                         </div>

                                         {{-- <div class="mb-3">
                                          <label for="barcode" class="form-label">Barcode</label>
                                          <input type="text" class="form-control" id="barcode" name="barcode">
                                      </div> --}}

                                      </div>
                                      
                                      <div class="mb-4">
                                       
                                      <textarea name="des" id="des" cols="59" rows="6"></textarea>
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
                           url: "{{ route('book.deleteSelected') }}", // Laravel route for deleting roles
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

                $('#formSave').on('submit', function(event) {
                  event.preventDefault(); // Prevent default form submission

                  var formData = new FormData(this); // Create FormData object from the form
                  var id = $('#id').val(); // Get the ID for update
                  var url = id ? `/book/update/${id}` : '/book/store'; // Set URL based on ID

                  // If updating, spoof the PUT method
                  if (id) {
                        formData.append('_method', 'PUT'); // Spoofing for PUT method
                  }

                  $.ajax({
                        url: url,
                        type: 'POST', // Always POST
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                           $('#modalForm').modal('hide'); // Hide modal
                           location.reload(); // Reload the page to see changes
                        },
                        error: function(xhr) {
                           console.error('Error:', xhr.responseText); // Log error response
                        }
                  });
               });

                     // Load data into modal for update
                     $(document).on('click', '.btnEdit', function() {
                        var id = $(this).data('id');
                        // $('#editpass').hide();
                        // Fetch data for user and populate form
                        $.ajax({
                           url: '/book/edit/' + id,
                           type: 'GET',
                           success: function(data) {
                                 $('#id').val(data.id);
                                 $('#title_en').val(data.title_en);
                                 $('#title_kh').val(data.title_kh);
                                 $('#authors_id').val(data.authors_id);
                                 $('#genres_id').val(data.genres_id);
                                 // $('#barcode').val(data.barcode);
                                 $('#des').val(data.des);
                                 $('#cover_book').val('');
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
                            url: "{{ route('book.delete') }}", // Your Laravel route to handle the form submission
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