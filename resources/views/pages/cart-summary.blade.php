<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
 <!-- Invoice Container (hidden initially) -->
 <div id="invoice-container" style="display: none;">
    <!-- Invoice will be dynamically added here -->
</div>
<ul id="cart-summary">
    @forelse($cartItems as $cartItem)
        <li class="shadow list-group-item py-3 ps-2" id="cart-item-{{ $cartItem->id }}">
            <div class="row align-items-center">
                <div class="col-6 col-md-6 col-lg-7">
                    <div class="d-flex">
                        <img src="{{ Storage::url($cartItem->book->cover_book) }}" alt="{{ $cartItem->book->title_en }}" class="icon-shape icon-xxl" />
                        <div class="ms-3">
                            <h6 class="mb-0">{{ $cartItem->book->{'title_' . app()->getLocale()} }}</h6>
                            <div class="mt-2 small lh-1">
                                <a href="#!" class="text-decoration-none text-inherit remove-cart-item text-danger" data-cart-id="{{ $cartItem->id }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    <span class="text-muted">{{ __('globle.remove') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 col-md-4 col-lg-3">
                    <div class="input-group input-spinner">
                        <input type="button" value="-" class="button-minus btn btn-sm" data-cart-id="{{ $cartItem->id }}" />
                        <input type="number" step="1" max="10" value="{{ $cartItem->quantity }}" name="quantity" class="quantity-field form-control-sm form-input" />
                        <input type="button" value="+" class="button-plus btn btn-sm" data-cart-id="{{ $cartItem->id }}" />
                    </div>
                </div>
                
                <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                    <span class="fw-bold">${{ number_format($cartItem->total, 2) }}</span>
                </div>
            </div>
        </li>
       
    @empty
        <li class="list-group-item text-center">{{ __('globle.cartEmpty') }}</li>
    @endforelse
    

    <div class="mt-5">
        <div class="card shadow p-4">

            <form>
                <div class="row">
                    <div class="col-md-4">
                            <label for="coupon" class="form-label">Coupon</label>
                            <input type="number" class="form-control" placeholder="$" id="coupon"  min="0" max="100">
                    </div>

                    <div class="col-md-4">
                        <label for="recived_amount" class="form-label">Recived Amount</label>
                        <input type="number" class="form-control" placeholder="$" id="recived_amount">
                    </div>

                    <div class="col-md-4">
                        <label for="change_return" class="form-label">Change Return:</label>
                        <input type="text" class="form-control" value="" id="change_return" name="change_return" readonly>
                    </div>

                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th>Subtotal</th>
                        <th scope="col">{{ __('globle.total') }}</th>
                        <th scope="col">$ Coupon</th>
                        <th scope="col">{{ __('globle.totalItem') }}</th>
                        <th scope="col">{{ __('globle.pay') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="subtotal">${{ number_format($subtotal, 2) }}</td>
                        <td id="total">${{ number_format($subtotal, 2) }}</td>
                        <td id="couponAmount">$0.00</td>
                        <td id="totalItems">{{ $totalItems }}</td>
                        <td><button class="btn btn-primary btn-pay">Pay</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let subtotal = parseFloat("{{ $subtotal }}");
            let total = 0; // Get the subtotal from Laravel
    
            $("#coupon").on("input", function () {
                let couponPercent = parseFloat($(this).val()) || 0; // Get the discount percentage or 0
                total = subtotal - couponPercent; // Apply discount
    
                $("#subtotal").text(`$${subtotal.toFixed(2)}`);
                $("#couponAmount").text(`$${couponPercent.toFixed(2)}`); // Show discount amount
                $("#total").text(`$${total.toFixed(2)}`);

            });

            $("#recived_amount").on("input", function () {
           let receivedAmount = parseFloat($(this).val()) || 0; // Get received amount or 0
           let changeReturn = receivedAmount - total; // Calculate change return
           
           // Ensure the change return does not display NaN
           if (isNaN(changeReturn)) {
               changeReturn = 0;
           }
   
           $("#change_return").val(`$ ${changeReturn.toFixed(2)}`);
        });

       });
  
    </script>
   
</ul>
<!-- Invoice Container -->




