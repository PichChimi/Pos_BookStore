@extends('layouts.app')
@section('title') SALE - BOOKLE @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<script src="{{asset('assets/js/vendors/validation.js')}}"></script>

<main>
  
   <!-- section -->
   <section class="mb-lg-14 mb-8 mt-8">

      <div class="col-xxl-5 col-lg-4 d-none d-lg-block" style="margin-left: 17px">
         <form id="barcode-form">
            <div id="error-message" class="alert alert-danger" style="display: none;"></div>
            <div id="success-message" class="alert alert-primary" style="display: none;"></div>
            <div class="input-group">
                <input id="barcode-input" class="form-control rounded" type="search" placeholder="Barcode" />
                <span class="input-group-append">
                    <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end" type="button" id="barcode-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </span>
            </div>
        </form>
      </div>
      
      <div class="container-fluid">
        
         <!-- row -->
         <div class="row">


            <div class="col-lg-6 col-md-7">
               <div class="py-3 mt-3">
                 
                  <ul class="list-group list-group-flush">
                     <div id="error-message" class="alert alert-danger" style="display:none;"></div>
                     <div id="cart-summary-container">
                        @include('pages.cart-summary', ['cartItems' => $cartItems, 'subtotal' => $subtotal, 'totalItems' => $totalItems])
                    </div>
            
                    
                  </ul>
                  

               </div>
            </div>

            <!-- sidebar -->
            <div class="col-12 col-lg-6 col-md-7">
               <!-- card -->
               <div class="mb-5 card mt-6">
                  <div class="card-body p-6">
                      
                     <div class="row g-4 row-cols-lg-4 row-cols-2 row-cols-md-3 mt-2">
                        <!-- col -->
                        @foreach($books as $book)
                          @foreach($book->stocks as $stock)
                        <div class="col">
                           <!-- card product -->
                           <div class="card card-product">
                              <div class="card-body">
                                 <!-- badge -->
                                 <div class="text-center position-relative" style="cursor: pointer" >
                                    <div class="position-absolute top-0 start-0">
                                       <span class="badge bg-danger">${{ $stock->selling_price }}</span>
                                    </div>
                                    <div>
                                       <img src="{{ Storage::url($book->cover_book) }}" alt="{{ $book->title_en }}" class="add-to-cart-button mb-3 img-fluid" data-book-id="{{ $book->id }}" data-stock-id="{{ $stock->id }}" />
                                    </div>

                                 </div>
                                 <!-- heading -->
                                 <div class="text-small mb-1">
                                    <a href="#!" class="text-decoration-none text-muted"><small>{{ $book->genres->{'name_' . app()->getLocale()} }}</small></a>
                                 </div>
                                 <h2 class="fs-6"><a href="#" class="text-inherit text-decoration-none">{{ $book->{'title_' . app()->getLocale()} }}</a></h2>
                                 
                                 <!-- price -->
                                 <div class="d-flex justify-content-between align-items-center mt-3">
                                    
                                  
                                   
                                 </div>
                              </div>
                           </div>
                        </div>
                           @endforeach
                        @endforeach
 
                     </div>
                     


                  </div>
               </div>
            </div>

         </div>
      </div>
   </section>

   <script>
      $(document).ready(function() {

          // Function to update the cart summary
          function updateCartSummary(html) {
                $('#cart-summary-container').html(html);
            }


         $('.add-to-cart-button').click(function() {
            const bookId = $(this).data('book-id');
            const stockId = $(this).data('stock-id');
            $.ajax({
               url: '/cart/store',
               method: 'POST',
               data: {
                     book_id: bookId,
                     stock_id: stockId,
                     _token: '{{ csrf_token() }}' // Ensure you include the CSRF token
               },
               success: function(response) {
                     // Update cart UI here
                     // $('#cart-summary').html(response.cartHtml);
                     updateCartSummary(response.cartHtml);
                     // alert(response.success);
               },
               error: function(xhr) {
                     const errorMessage = xhr.responseJSON.error || 'Error adding item to cart.';
                     alert(errorMessage);
               }
            });
         });

       
        // Event listener for increment and decrement buttons
        $(document).on('click', '.button-minus, .button-plus', function(event) {
            event.preventDefault(); // Prevent default link behavior

            const isIncrement = $(this).hasClass('button-plus');
            const quantityField = $(this).siblings('.quantity-field');
            const cartId = $(this).data('cart-id');
            let quantity = parseInt(quantityField.val());

            // Increment or decrement the quantity
            quantity = isIncrement ? quantity + 1 : Math.max(1, quantity - 1);
            quantityField.val(quantity);

            // Send AJAX request to update quantity
            $.ajax({
                url: `/cart/update/${cartId}`,
                method: 'POST',
                data: {
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Update the cart summary section with new HTML
                    if (response.subtotal && response.totalItems) {
                        $('#cart-summary-container').html(response.cartHtml);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

            $(document).on('click', '.remove-cart-item', function(e) {
            e.preventDefault();

            const cartId = $(this).data('cart-id');
            
            // Show confirmation dialog
            if (!confirm("Are you sure you want to remove this item from the cart?")) {
                  return; // Exit if the user cancels
            }

            $.ajax({
                  url: `/cart/remove/${cartId}`,  // Assuming this route exists
                  method: 'DELETE',
                  data: {
                     _token: $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response) {
                     // Update the cart summary HTML
                     $('#cart-summary-container').html(response.cartHtml);
                  },
                  error: function(xhr) {
                     console.error(xhr.responseText);
                  }
            });
         });



         $('#barcode-form').on('submit', function(e) {
            e.preventDefault();
            addToCartByBarcode();
        });

        $('#barcode-submit').on('click', function() {
            addToCartByBarcode();
        });

        function addToCartByBarcode() {
            const barcode = $('#barcode-input').val();
            $.ajax({
                url: '{{ route("cart.addByBarcode") }}', // Adjust this route name to match your route
                method: 'POST',
                data: {
                    barcode: barcode,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                  if (response.success) {
                        $('#cart-summary-container').html(response.cartHtml);
                        $('#barcode-input').val(''); // Clear the input field
                        $('#error-message').hide(); // Hide error message if successful
                        $('#success-message').text(response.success);
                    } else if (response.error) {
                       $('#error-message').text(response.error).show(); // Show error message
                    }
                },
                error: function(xhr) {
                  // Handle different types of errors
                  if (xhr.status === 404) {
                        $('#error-message').text("Book not found. Please check the barcode.").show();
                    } else if (xhr.status === 422) {
                        $('#error-message').text("Validation error. Please check your input.").show();
                    } else {
                        $('#error-message').text("An unexpected error occurred. Please try again.").show();
                    }
                }
            });
        }

         // Payment
         // Handle the Pay button click
         $(document).on('click', '.btn-pay', function () {
            // Confirm before proceeding
            if (!confirm('Are you sure you want to complete the payment?')) {
                return;
            }

            $.ajax({
                url: '{{ route("cart.pay") }}', // Your route for handling the payment
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    alert(response.message);

                    // Clear the cart summary container
                    $('#cart-summary').html('<li class="list-group-item text-center">Your cart is empty.</li>');

                    // Update other parts of the UI if necessary
                    $('#subtotal').text('$0.00');
                    $('#total').text('$0.00');
                    $('#totalItems').text('0');
                },
                error: function (xhr) {
                    alert('An error occurred: ' + (xhr.responseJSON?.error || 'Unknown error'));
                }
            });
        });
         

      });
      </script>

</main>

@endsection