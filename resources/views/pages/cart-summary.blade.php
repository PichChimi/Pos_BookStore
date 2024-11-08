<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<ul id="cart-summary">
    @forelse($cartItems as $cartItem)
        <li class="list-group-item py-3 ps-0 border-top" id="cart-item-{{ $cartItem->id }}">
            <div class="row align-items-center">
                <div class="col-6 col-md-6 col-lg-7">
                    <div class="d-flex">
                        <img src="{{ Storage::url($cartItem->book->cover_book) }}" alt="{{ $cartItem->book->title_en }}" class="icon-shape icon-xxl" />
                        <div class="ms-3">
                            <h6 class="mb-0">{{ $cartItem->book->{'title_' . app()->getLocale()} }}</h6>
                            <div class="mt-2 small lh-1">
                                <a href="#!" class="text-decoration-none text-inherit remove-cart-item" data-cart-id="{{ $cartItem->id }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    <span class="text-muted">Remove</span>
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
        <li class="list-group-item text-center">Your cart is empty.</li>
    @endforelse

    <table class="table table-striped">
        <thead>
            <tr class="table-primary">
                <th scope="col">Subtotal</th>
                <th scope="col">Total</th>
                <th scope="col">Total (Items)</th>
                <th scope="col">Pay</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="subtotal">${{ number_format($subtotal, 2) }}</td>
                <td id="total">${{ number_format($subtotal, 2) }}</td>
                <td id="totalItems">{{ $totalItems }}</td>
                <td><button class="btn btn-pay">Pay</button></td>
            </tr>
        </tbody>
    </table>
</ul>


