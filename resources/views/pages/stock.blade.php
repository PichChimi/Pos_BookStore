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
                  <h2>{{ __('globle.stock') }}</h2>
                 
               </div>
               <!-- button -->
               <div>
                  <a href="#" id="btnmodal" class="btn btn-primary">{{ __('globle.addstock') }}</a>
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
                           <input class="form-control" type="search" placeholder="{{ __('globle.searchstock') }}" aria-label="Search" />
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
                              <th>{{ __('globle.book') }}</th>
                              <th>{{ __('globle.qty') }}</th>
                              <th>{{ __('globle.const') }}</th>
                              <th>{{ __('globle.price') }}</th>
                              <th>{{ __('globle.supplier') }}</th>
                              <th>{{ __('globle.action') }}</th>
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

                                    <td 
                                        data-supplier-id="{{ $stock->supplier?->id ?? 'N/A' }}" 
                                        data-supp-en="{{ $stock->supplier?->name_en ?? 'N/A' }}" 
                                        data-supp-kh="{{ $stock->supplier?->name_kh ?? 'N/A' }}">
                                        {{ $stock->supplier?->{'name_' . app()->getLocale()} ?? 'No Supplier' }}
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
                                  <!-- Hidden Field for ID -->
                                  <input type="hidden" class="form-control" id="id" name="id">
              
                                  <div class="row">
                                      <!-- Book Dropdown -->
                                      <div class="col-lg-6">
                                          <div class="mb-3">
                                              <label class="form-label">{{ __('globle.book') }}</label>
                                              <select class="form-select" id="book_id" name="book_id" required>
                                                  <option value="" selected disabled>Select Book</option>
                                                  @foreach($books as $book)
                                                  <option value="{{ $book->id }}">{{ $book->title_en }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
              
                                          <!-- Purchase Price -->
                                          <div class="mb-3">
                                              <label for="purchase_price" class="form-label">{{ __('globle.const') }}</label>
                                              <input type="text" class="form-control" id="purchase_price" name="purchase_price" required>
                                          </div>
                                      </div>
              
                                      <!-- Quantity and Selling Price -->
                                      <div class="col-lg-6">
                                          <div class="mb-3">
                                              <label for="quantity" class="form-label">{{ __('globle.qty') }}</label>
                                              <input type="number" class="form-control" id="quantity" name="quantity" required>
                                          </div>
              
                                          <div class="mb-3">
                                              <label for="selling_price" class="form-label">{{ __('globle.price') }}</label>
                                              <input type="text" class="form-control" id="selling_price" name="selling_price" required>
                                          </div>
                                      </div>
                                  </div>
              
                                  <!-- Supplier Dropdown -->
                                  <div class="mb-3">
                                      <label class="form-label">{{ __('globle.supplier') }}</label>
                                      <select class="form-select" id="supplier_id" name="supplier_id" required>
                                          <option value="" selected disabled>Select Supplier</option>
                                          @foreach($suppliers as $supplier)
                                          <option value="{{ $supplier->id }}">{{ $supplier->name_en }}</option>
                                          @endforeach
                                      </select>
                                  </div>
              
                                  <!-- Save and Update Buttons -->
                                  <button type="submit" id="btnSave" class="btn btn-primary">{{ __('globle.save') }}</button>
                                  <button type="button" id="btnUpdate" class="btn btn-primary">{{ __('globle.edit') }}</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>

         <!-- end Modal -->
<script>

   $(document).ready(function(){

      $(document).ready(function () {
    // =========== Use Option =========

    // Select or Deselect All Checkboxes
    $('#checkAll').on('click', function () {
        $('.select-checkbox').prop('checked', this.checked);
    });

    // Handle select change event
    $('#statusSelect').on('change', function () {
        const selectedOption = $(this).val();

        if (selectedOption === 'deleteSelected') {
            const selectedIds = [];
            $('.select-checkbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('Please select at least one item to delete.');
                return;
            }

            if (!confirm('Are you sure you want to delete the selected items?')) {
                $(this).val('Status'); // Reset the dropdown
                return;
            }

            $.ajax({
                url: "{{ route('stock.deleteSelected') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: selectedIds,
                },
                success: function (response) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Stock has been deleted successfully.',
                        timer: 2000, // Modal will auto-close after 2 seconds
                        showConfirmButton: false // Hides the "OK" button
                    }).then(() => {
                        location.reload(); // Reload the page after the modal closes
                    });
                },
                error: function (xhr) {
                    alert('Error occurred while deleting items.');
                }
            });

            $(this).val('Status'); // Reset dropdown
        }
    });

    // Modal - Add Stock
    $('#btnmodal').click(function () {
        $('#modalForm').modal('show');
        $('#btnUpdate').hide();
        $('#btnSave').show();
        $('#formSave')[0].reset();
    });

    // Insert Stock Data
    $('#formSave').on('submit', function (e) {
        e.preventDefault();

        const formData = {
            book_id: $('#book_id').val(),
            quantity: $('#quantity').val(),
            purchase_price: $('#purchase_price').val(),
            selling_price: $('#selling_price').val(),
            supplier_id: $('#supplier_id').val(),
            _token: "{{ csrf_token() }}",
        };

        $.ajax({
            url: "{{ route('stock.store') }}",
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#modalForm').hide('show');
                    Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Stock has been inserted successfully.',
                    timer: 2000, // Modal will auto-close after 2 seconds
                    showConfirmButton: false // Hides the "OK" button
                }).then(() => {
                    location.reload(); // Reload the page after the modal closes
                });
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            },
        });
    });

    // Edit Stock Data
    $('#dataTable').on('click', '.btnEdit', function () {
    const currentRow = $(this).closest('tr');
    
    // Fill form inputs with existing data
    $('#id').val(currentRow.find('td').eq(1).text());
    $('#book_id').val(currentRow.find('td').eq(2).data('book-id'));
    $('#quantity').val(currentRow.find('td').eq(3).text());
    $('#purchase_price').val(currentRow.find('td').eq(4).text());
    $('#selling_price').val(currentRow.find('td').eq(5).text());
    $('#supplier_id').val(currentRow.find('td').eq(6).data('supplier-id'));

    // Show Update button, hide Save button
    $('#btnSave').hide();
    $('#btnUpdate').show();

    // Show modal
    $('#modalForm').modal('show');
});

$('#btnmodal').click(function () {
    // Clear form inputs
    $('#formSave')[0].reset();

    // Reset dropdowns to default
    $('#book_id, #supplier_id').val('').trigger('change');

    // Show Save button, hide Update button
    $('#btnSave').show();
    $('#btnUpdate').hide();

    // Show modal
    $('#modalForm').modal('show');
});
    // Update Stock Data
    $('#btnUpdate').click(function () {
      const formData = {
         id: $('#id').val(),
         book_id: $('#book_id').val(),
         quantity: $('#quantity').val(),
         purchase_price: $('#purchase_price').val(),
         selling_price: $('#selling_price').val(),
         supplier_id: $('#supplier_id').val(),
         _token: "{{ csrf_token() }}",
      };

    $.ajax({
        url: "{{ route('stock.update') }}",
        method: "PUT",
        data: formData,
        success: function (response) {
               $('#modalForm').hide('show');
                Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Stock has been updated successfully.',
                timer: 2000, // Modal will auto-close after 2 seconds
                showConfirmButton: false // Hides the "OK" button
            }).then(() => {
                location.reload(); // Reload the page after the modal closes
            });
        },
        error: function (xhr) {
            console.error(xhr.responseJSON); // Log errors for debugging
            alert('Validation Error: ' + xhr.responseJSON.message);
        },
    });

    $('#modalForm').modal('hide');
});

    // Delete Stock Data
    $('#dataTable').on('click', '.btnDelete', function () {
        const currentRow = $(this).closest('tr');
        const id = currentRow.find('td').eq(1).text();

        if (confirm("Are you sure to delete?")) {
            $.ajax({
                url: "{{ route('stock.delete') }}",
                method: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function (response) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Stock has been updated successfully.',
                        timer: 2000, // Modal will auto-close after 2 seconds
                        showConfirmButton: false // Hides the "OK" button
                    }).then(() => {
                        location.reload(); // Reload the page after the modal closes
                    });
                },
                error: function (xhr) {
                    alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Unexpected error occurred.'));
                },
            });
        }
    });

    // Fetch Stock Details for Selected Book
    $('#book_id').change(function () {
        const bookId = $(this).val();

        if (bookId) {
            $.ajax({
                url: '/stock/get-details',
                method: 'GET',
                data: { book_id: bookId },
                success: function (response) {
                    if (response.stock) {
                        $('#purchase_price').val(response.stock.purchase_price);
                        $('#selling_price').val(response.stock.selling_price);
                        $('#supplier_id').val(response.stock.supplier_id);
                    } else {
                        $('#purchase_price, #selling_price').val('');
                        $('#supplier_id').val('');
                    }
                },
                error: function () {
                    alert('Error fetching stock details.');
                }
            });
        } else {
            $('#purchase_price, #selling_price, #supplier_id').val('');
        }
    });
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