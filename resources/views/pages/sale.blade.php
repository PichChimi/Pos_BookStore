@extends('layouts.app')
@section('title') SALE - BOOKLE @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<script src="{{asset('assets/js/vendors/validation.js')}}"></script>

<main>
  
   <!-- section -->
   <section class="mb-lg-14 mb-8 mt-8">

      <div class="col-xxl-5 col-lg-4 d-none d-lg-block" style="margin-left: 50px">
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

         <div class="d-flex justify-content-end">
                   <!-- Genres Navigation -->
                   <nav>
                     <ul class="nav nav-pills nav-scroll border-bottom-0 gap-1" id="genre-tabs" role="tablist">
                         <!-- All tab -->
                         <li class="nav-item">
                             <a href="#"
                                class="nav-link active"
                                data-genre-id="all">
                                   {{ __('All') }}
                             </a>
                         </li>
                 
                         <!-- Dynamic genre tabs -->
                         @foreach($genres as $genre)
                         <li class="nav-item">
                             <a href="#"
                                class="nav-link"
                                data-genre-id="{{ $genre->id }}">
                                   {{ $genre->{'name_' . app()->getLocale()} }}
                             </a>
                         </li>
                         @endforeach
                     </ul>
                 </nav>
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
                      
                     <!-- Books Section -->
                  <div id="books-container" class="row g-3 row-cols-lg-3 row-cols-2 row-cols-md-3 mt-2">
                        @include('partials.books', ['books' => $books]) 
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
          function updateCartSummary(html)
          {
                $('#cart-summary-container').html(html);
          }

          // Add Book to cart
            $(document).on('click', '.add-to-cart-button', function () {
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
                     updateCartSummary(response.cartHtml);
               },
               error: function(xhr) {
                     const errorMessage = xhr.responseJSON.error || 'Error adding item to cart.';
                     alert(errorMessage);
               }
            });
         });

        // Event listener for increment and decrement buttons
        $(document).on('click', '.button-minus, .button-plus', function(event) {
            event.preventDefault(); 

            const isIncrement = $(this).hasClass('button-plus');
            const quantityField = $(this).siblings('.quantity-field');
            const cartId = $(this).data('cart-id');
            let quantity = parseInt(quantityField.val());

            // Increment or decrement the quantity
            quantity = isIncrement ? quantity + 1 : Math.max(1, quantity - 1);
            quantityField.val(quantity);

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


            // Remove Cart
            $(document).on('click', '.remove-cart-item', function(e) {
            e.preventDefault();

            const cartId = $(this).data('cart-id');
            
            if (!confirm("Are you sure you want to remove this item from the cart?")) {
                  return; 
            } 

            $.ajax({
                  url: `/cart/remove/${cartId}`, 
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

        // Add to cart by Barcode
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
      $(document).on('click', '.btn-pay', function () {
            if (!confirm('Are you sure you want to proceed with the payment?')) {
                return;
            }

            $.ajax({
                url: '{{ route("cart.pay") }}', // Adjust route as necessary
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert(response.message);

                    // Display the invoice
                    $('#invoice-container').html(response.invoiceHtml).show();

                    // Clear the cart summary
                    $('#cart-summary').html('<li class="list-group-item text-center">Your cart is empty.</li>');
                },
                error: function (xhr) {
                    if (xhr.responseJSON?.errorstock) {
                        alert(xhr.responseJSON.errorstock);
                    } else {
                        alert('Payment failed. Please try again.');
                    }
                }
            });
        });

        // Handle the Print Invoice button click
         $(document).on('click', '#print-invoice', function () {
            var invoiceContent = document.getElementById('invoice-container').innerHTML;

            // Check if content is valid
            if (!invoiceContent.trim()) {
               alert('No invoice content to print.');
               return;
            }

            // Open a new window and print the invoice
            var printWindow = window.open('', '', 'height=700,width=900');
            printWindow.document.write('<html><head><title>Invoice</title></head><body>');
            printWindow.document.write(invoiceContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
         });

         $('#genre-tabs .nav-link').on('click', function (e) {
        e.preventDefault(); // Prevent default anchor behavior

        // Remove active class from all tabs and add to the clicked one
        $('#genre-tabs .nav-link').removeClass('active');
        $(this).addClass('active');

        // Get the genre ID from the data attribute
        let genreId = $(this).data('genre-id');

        // Send an AJAX request to fetch books
        $.ajax({
            url: "{{ route('books.by.genre') }}", // Route to fetch books
            method: "GET",
            data: { genre_id: genreId },
            beforeSend: function () {
                $('#books-container').html('<p>Loading books...</p>');
            },
            success: function (response) {
                // Update the books container with the fetched data
                $('#books-container').html(response.html);
            },
            error: function () {
                $('#books-container').html('<p class="text-danger">An error occurred while loading books.</p>');
            }
        });
    });

    // Trigger click event on the "All" tab on page load to show all books initially
    $('#genre-tabs .nav-link[data-genre-id="all"]').trigger('click');
         

      });
      </script>

</main>

@endsection