@extends('layouts.app')
@section('title') Stock - BOOKLE @endsection
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
                  <h2>Stock</h2>
                 
               </div>
               <!-- button -->
               <div>
                  <a href="#" id="btnmodal" class="btn btn-primary">Add New Stock</a>
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
                              <th>Book</th>
                              <th>Quantity</th>
                              <th>Purchase Price</th>
                              <th>Selling Price</th>
                              <th>Supplier</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($stocks as $stock)
                                 <tr>
                                    <td>
                                       <div class="form-check">
                                          <input class="form-check-input select-checkbox" type="checkbox" value="{{ $stock->id }}" id="role_{{ $stock->id }}" />
                                          <label class="form-check-label" for="role_{{ $stock->id }}"></label>

                                       </div>
                                    </td>
                              
                                    <td>{{ $stock->id }}</td>

                                    <td data-book-id="{{ $stock->book->id }}" data-name-en="{{ $stock->book->title_en }}" data-name-kh="{{ $stock->book->title_kh }}">
                                       {{ $stock->book->{'title_' . app()->getLocale()} }}
                                    </td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>{{ $stock->purchase_price }}</td>
                                    <td>{{ $stock->selling_price }}</td>

                                    <td data-supplier-id="{{ $stock->supplier->id }}" data-supp-en="{{ $stock->supplier->name_en }}" data-supp-kh="{{ $stock->supplier->name_kh }}">
                                       {{ $stock->supplier->{'name_' . app()->getLocale()} }}
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
                                 <label class="form-label">Book</label>
                                 <select class="form-select" id="book_id" name="book_id">
                                     @foreach($books as $book)
                                     <option value="{{ $book->id }}">{{ $book->title_en }}</option>
                                     @endforeach
                                 </select>
                             </div>


                              <div class="mb-3">
                                 <label for="purchase_price" class="form-label">Purchase Price</label>
                                 <input type="text" class="form-control" id="purchase_price" >
                              </div>

                             

                           </div>


                           <div class="col-lg-6">

                              <div class="mb-3">
                                 <label for="quantity" class="form-label">Quantity</label>
                                 <input type="number" class="form-control" id="quantity" name="quantity" >
                             </div>
                             

                              <div class="mb-3">
                                 <label for="selling_price" class="form-label">Selling Price</label>
                                 <input type="text" class="form-control" id="selling_price" >
                              </div>

                             

                           </div>

                        </div>

                        <div class="mb-3">
                           <label class="form-label">Supplier</label>
                           <select class="form-select" id="supplier_id" name="supplier_id">
                               @foreach($suppliers as $supplier)
                               <option value="{{ $supplier->id }}">{{ $supplier->name_en }}</option>
                               @endforeach
                           </select>
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
                           url: "{{ route('stock.deleteSelected') }}", // Laravel route for deleting roles
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
                    var book_id = $('#book_id').val();
                    var quantity = $('#quantity').val();
                    var purchase_price = $('#purchase_price').val();
                    var selling_price = $('#selling_price').val();
                    var supplier_id = $('#supplier_id').val();
                    

                     $.ajax({
                     url: "{{ route('stock.store') }}", // Your Laravel route to handle the form submission
                     method: "POST",
                     data: {
                           _token: "{{ csrf_token() }}", // CSRF Token for security
                              book_id: book_id,
                              quantity: quantity,
                              purchase_price: purchase_price,
                              selling_price: selling_price,
                              supplier_id: supplier_id,
                     },
                     success: function(response) {
                              // alert('Data inserted successfully!');
                              // window.location.href = "{{ route('author.index') }}";
                              location.reload();

                              $('#book_id').val('');
                              $('#quantity').val('');
                              $('#purchase_price').val('');
                              $('#selling_price').val('');
                              $('#supplier_id').val('');
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
                     var book_id = current_row.find('td').eq(2).data('book-id');
                     // var title_en = current_row.find('td').eq(2).data('name-en'); 
                     // var title_kh = current_row.find('td').eq(2).data('name-kh'); 
                     var quantity = current_row.find('td').eq(3).text();
                     var purchase_price = current_row.find('td').eq(4).text(); // Get 'name_kh' // Get 'name_kh'
                     var selling_price = current_row.find('td').eq(5).text(); // Get 'name_kh' // Get 'name_kh'
                     // var sname_en = current_row.find('td').eq(6).data('supp-en'); 
                     // var sname_kh = current_row.find('td').eq(6).data('supp-kh');
                     var supplier_id = current_row.find('td').eq(6).data('supplier-id');

                     $('#id').val(id);
                     $('#book_id').val(book_id);
                     $('#quantity').val(quantity);
                     $('#purchase_price').val(purchase_price);
                     $('#selling_price').val(selling_price);
                     $('#supplier_id').val(supplier_id);
                    

                    $('#modalForm').modal('show');
                    $('#btnSave').hide();

                    $('#btnUpdate').click(function(){
                        var id = $('#id').val();
                        var book_id = $('#book_id').val();
                        var quantity = $('#quantity').val();
                        var purchase_price = $('#purchase_price').val();
                        var selling_price = $('#selling_price').val();
                        var supplier_id = $('#supplier_id').val();
                       

                        $.ajax({
                            url: "{{ route('stock.update') }}", // Your Laravel route to handle the form submission
                            method: "PUT",
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token for security
                                id: id,
                                book_id: book_id,
                                quantity: quantity,
                                purchase_price: purchase_price,
                                selling_price: selling_price,
                                supplier_id: supplier_id,
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
                            url: "{{ route('stock.delete') }}", // Your Laravel route to handle the form submission
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