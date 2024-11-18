@extends('layouts.app')
@section('title') Supplier - BOOKLE @endsection
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
                  <h2>Supplier</h2>
                 
               </div>
               <!-- button -->
               <div>
                  <a href="#" id="btnmodal" class="btn btn-primary">Add New Supplier</a>
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
                              <th>Name</th>
                              <th>Company</th>
                              <th>Phone</th>
                              <th>Address</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($suppliers as $supplier)
                                 <tr>
                                    <td>
                                       <div class="form-check">
                                          <input class="form-check-input select-checkbox" type="checkbox" value="{{ $supplier->id }}" id="role_{{ $supplier->id }}" />
                                          <label class="form-check-label" for="role_{{ $supplier->id }}"></label>

                                       </div>
                                    </td>
                              
                                    <td>{{ $loop->index + 1 }}</td>

                                    <td data-name-en="{{ $supplier->name_en }}" data-name-kh="{{ $supplier->name_kh }}">
                                       {{ $supplier->{'name_' . app()->getLocale()} }}
                                    </td>
                                    <td>{{ $supplier->company }}</td>
                                    <td>{{ $supplier->p_number }}</td>

                                    <td data-address-en="{{ $supplier->address_en }}" data-address-kh="{{ $supplier->address_kh }}">
                                       {{ $supplier->{'address_' . app()->getLocale()} }}
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
                                                   <span class="text-danger">Delete</span>
                                                </a>
                                             </li>
                                             <li>
                                                <a class="dropdown-item btnEdit" href="#">
                                                   <i class="bi bi-pencil-square me-3"></i>
                                                   Edit
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

                        <div class="row">

                           <div class="col-lg-6">

                              <div class="mb-3">
                                 <label for="name_en" class="form-label">Name English</label>
                                 <input type="text" class="form-control" id="name_en" >
                              </div>

                              <div class="mb-3">
                                 <label for="p_number" class="form-label">Phone Number</label>
                                 <input type="text" class="form-control" id="p_number" >
                              </div>

                              <div class="mb-3">
                                 <label for="address_en" class="form-label">Address En</label>
                                 <input type="text" class="form-control" id="address_en" >
                              </div>

                           </div>


                           <div class="col-lg-6">

                              <div class="mb-3">
                                 <label for="name_kh" class="form-label">Name Khmer</label>
                                 <input type="text" class="form-control" id="name_kh" >
                              </div>

                              <div class="mb-3">
                                 <label for="company" class="form-label">Company</label>
                                 <input type="text" class="form-control" id="company" >
                              </div>

                              <div class="mb-3">
                                 <label for="address_kh" class="form-label">Address Kh</label>
                                 <input type="text" class="form-control" id="address_kh" >
                              </div>

                           </div>

                        </div>
                        

                        <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                        <a href="#" id="btnUpdate" class="btn btn-primary">Update</a>
                     
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
                           url: "{{ route('supplier.deleteSelected') }}", // Laravel route for deleting roles
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

                 //   Insert data
                 $('#formSave').on('submit', function(e){
                    e.preventDefault();
                    var name_en = $('#name_en').val();
                    var name_kh = $('#name_kh').val();
                    var p_number = $('#p_number').val();
                    var company = $('#company').val();
                    var address_en = $('#address_en').val();
                    var address_kh = $('#address_kh').val();

                     $.ajax({
                     url: "{{ route('supplier.store') }}", // Your Laravel route to handle the form submission
                     method: "POST",
                     data: {
                           _token: "{{ csrf_token() }}", // CSRF Token for security
                           name_en: name_en,
                           name_kh: name_kh,
                           p_number: p_number,
                           company: company,
                           address_en: address_en,
                           address_kh: address_kh
                     },
                     success: function(response) {
                              // alert('Data inserted successfully!');
                              // window.location.href = "{{ route('author.index') }}";
                              location.reload();

                              $('#name_en').val('');
                              $('#name_kh').val('');
                              $('#p_number').val('');
                              $('#company').val('');
                              $('#address_en').val('');
                              $('#address_kh').val('');
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
                     var company = current_row.find('td').eq(3).text();
                     var p_number = current_row.find('td').eq(4).text(); // Get 'name_kh' // Get 'name_kh'
                     var address_en = current_row.find('td').eq(5).data('address-en'); // Get 'name_en'
                     var address_kh = current_row.find('td').eq(5).data('address-kh'); // Get 'name_kh'
                     
                     $('#id').val(id);
                     $('#name_en').val(name_en);
                     $('#name_kh').val(name_kh);
                     $('#p_number').val(p_number);
                     $('#company').val(company);
                     $('#address_en').val(address_en);
                     $('#address_kh').val(address_kh);

                    $('#modalForm').modal('show');
                    $('#btnSave').hide();

                    $('#btnUpdate').click(function(){
                        var id = $('#id').val();
                        var name_en = $('#name_en').val();
                        var name_kh = $('#name_kh').val();
                        var p_number = $('#p_number').val();
                        var company = $('#company').val();
                        var address_en = $('#address_en').val();
                        var address_kh = $('#address_kh').val();

                        $.ajax({
                            url: "{{ route('supplier.update') }}", // Your Laravel route to handle the form submission
                            method: "PUT",
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token for security
                                id: id,
                                name_en: name_en,
                                 name_kh: name_kh,
                                 p_number: p_number,
                                 company: company,
                                 address_en: address_en,
                                 address_kh: address_kh
                            },
                            success: function(response) {
                                    // alert('Data updated successfully!');
                                    // window.location.href = "{{ route('author.index') }}";
                                    location.reload();
                            },
                            error: function(response) {
                                alert('Error occurred!');
                            }
                        });

                    });
                    $('#modalForm').modal('hide');
                    
                     
                  });
                  //  end Edit

                  // Delete
                  $('#dataTable').on('click', '.btnDelete',function(){
                    var current_row = $(this).closest('tr');
                    var id = current_row.find('td').eq(1).text();
                    var con = confirm("Are you sure to delete?");
                    if(con == true){
                        $.ajax({
                            url: "{{ route('supplier.delete') }}", // Your Laravel route to handle the form submission
                            method: "Delete",
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token for security
                                id: id,
                            },
                            success: function(response) {
                                    // alert('Data Delete successfully!');
                                    // window.location.href = "{{ route('author.index') }}";
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