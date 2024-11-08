@extends('layouts.authentication')

@section('content')

<main>
    <!-- section -->

    <section class="my-lg-14 my-8">
       <!-- container -->
       <div class="container">
          <!-- row -->
          <div class="row justify-content-center align-items-center">
             <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                <!-- img -->
                <img src="../assets/images/svg-graphics/signup-g.svg" alt="" class="img-fluid" />
             </div>
             <!-- col -->
             <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                <div class="mb-lg-9 mb-5">
                   <h1 class="mb-1 h2 fw-bold">Get Start Shopping</h1>
                   <p>Welcome to FreshCart! Enter your email to get started.</p>
                </div>
                <!-- form -->
                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                    @csrf
                   <div class="row g-3">
                      <!-- col -->
                      <div class="col-12">
                         <!-- input -->
                         <label for="formSignupfname" class="form-label visually-hidden">First Name</label>
                         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="First Name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                         <div class="invalid-feedback">Please enter name.</div>
                      </div>
                     
                      <div class="col-12">
                         <!-- input -->
                         <label for="formSignupEmail" class="form-label visually-hidden">Email address</label>
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                         <div class="invalid-feedback">Please enter email.</div>
                      </div>

                      <div class="col-12">
                         <!-- input -->
                         <label for="password" class="form-label visually-hidden">Password</label>
                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                         <div class="invalid-feedback">Please enter password.</div>
                      </div>

                      <div class="col-12">
                         <div class="password-field position-relative">
                            <label for="password-confirm" class="form-label visually-hidden">Password</label>
                            <div class="password-field position-relative">
                               <input id="password-confirm" type="password" class="form-control fakePassword" name="password_confirmation" placeholder="*****" required autocomplete="new-password">
                               <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                               <div class="invalid-feedback">Please enter password.</div>
                            </div>
                         </div>
                      </div>

                      <!-- btn -->
                      <div class="col-12 d-grid">
                          <button type="submit" class="btn btn-primary">Register</button>
                     </div>
                    

                      <!-- text -->
                      <p>
                         <small>
                            By continuing, you agree to our
                            <a href="#!">Terms of Service</a>
                            &
                            <a href="#!">Privacy Policy</a>
                         </small>
                      </p>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </section>
 </main>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
