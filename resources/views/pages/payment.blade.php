
@extends('layouts.app')
@section('title') Payment - BOOKLE @endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
    $totalItems = request('totalItems', 0);
    $subtotal = request('subtotal', 0);
    $coupon = request('discount', 0);
    $total = request('total', 0);
@endphp
@section('content')

<script src="{{asset('assets/js/vendors/validation.js')}}"></script>

<main>
   <div class="container">
         <div class="row mt-10">

            <div class="col-md-8">
               <div class="card shadow p-8 rounded-3">
                  <form id="paymentForm">
                  <div class="row">

                     <div class="col-lg-6">

                         <div class="mb-3">
                             <label for="receved_amount" class="form-label">Recived Amount</label>
                             <input type="number" class="form-control" id="receved_amount" name="receved_amount">
                         </div>

                         <div class="mb-3">
                           <label for="change_return" class="form-label">Change Return:</label>
                           <input type="text" class="form-control" value="" id="change_return" name="change_return" readonly>
                       </div>

                     </div>

                     <div class="col-lg-6">

                        <div class="mb-3">
                            <label for="paying_amount" class="form-label">Paying Amount</label>
                            <input type="text" class="form-control" value="$ {{ number_format($total, 2) }}" id="paying_amount" name="paying_amount" readonly>
                        </div>

                        <div class="mb-3">
                           <label for="payment_type" class="form-label">Payment Type</label>
                           <select class="form-select" id="payment_type" name="payment_type">
                              <option value="Cash">Cash</option>
                              <option value="ABA">ABA</option>
                              <option value="Wing">Wing</option>
                          </select>
                       </div>

                    </div>

                  </div>
                  <button type="submit" class="btn btn-primary mt-3 shadow">Submit & Print</button>
                  </form>

               </div>

               {{-- <button type="submit" href="" class="btn btn-primary mt-7">Submit & Print</button> --}}
               <a href="{{ route('cart.pay',) }}">Submit & Print</a>
              

            </div>

           
            <div class="col-md-4">
               <div class="cadr shadow p-5 rounded-3">
                  <table class="table table-bordered">

                         <tr>
                             <th>Total Items</th>
                             <td>{{ $totalItems }}</td>
                         </tr>

                         <tr>
                           <th>Total Amount</th>
                           <td>$ {{ number_format($subtotal, 2) }}</td>
                         </tr>

                         <tr>
                           <th>Coupon</th>
                           <td>$ {{ number_format($coupon, 2) }}</td>
                         </tr>

                          <tr>
                              <th>Grand Total</th>
                              <td>$ {{ number_format($total, 2) }}</td>
                        </tr>
                 </table>
               </div>
            
            </div>

         </div>
   </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
        // Function to get query parameters from the URL
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return parseFloat(urlParams.get(param)) || 0;
        }

        let amount = getQueryParam("total"); // Get total from URL
        let subtotal = getQueryParam("subtotal"); // Get subtotal from URL
    //    let amount = parseFloat("{{ $total }}"); // Get the total from Laravel
    //    let subtotal = parseFloat("{{ $subtotal }}"); 
      
       $("#receved_amount").on("input", function () {
           let receivedAmount = parseFloat($(this).val()) || 0; // Get received amount or 0
           let changeReturn = receivedAmount - amount; // Calculate change return
           
           // Ensure the change return does not display NaN
           if (isNaN(changeReturn)) {
               changeReturn = 0;
           }
   
           $("#change_return").val(`$ ${changeReturn.toFixed(2)}`);
       });

      
   });
</script>

@endsection