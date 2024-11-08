@extends('layouts.authentication')

@section('content')


    <!-- section -->
    <section class="my-lg-14 my-8">
       <div class="container">
          <!-- row -->
          <div class="row justify-content-center align-items-center">
             <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                <!-- img -->
                <img src="../assets/images/svg-graphics/signin-g.svg" alt="" class="img-fluid" />
             </div>
             <!-- col -->
             <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                <div class="mb-lg-9 mb-5">
                   <h1 class="mb-1 h2 fw-bold">Sign in to FreshCart</h1>
                   <p>Welcome back to FreshCart! Enter your email to get started.</p>
                </div>

                <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                   <div class="row g-3">
                      <!-- row -->

                      <div class="col-12">
                         <!-- input -->
                         <label for="formSigninEmail" class="form-label visually-hidden">Email address</label>
                         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                         <div class="invalid-feedback">Please enter name.</div>
                      </div>

                      <div class="col-12">
                         <!-- input -->
                         <div class="password-field position-relative">
                            <label for="formSigninPassword" class="form-label visually-hidden">Password</label>
                            <div class="password-field position-relative">
                               <input id="password" type="password" class="form-control fakePassword @error('password') is-invalid @enderror" name="password" required placeholder="*****" autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                               <div class="invalid-feedback">Please enter password.</div>
                            </div>
                         </div>
                      </div>

                      <div class="d-flex justify-content-between">
                         <!-- form check -->
                         <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                            <!-- label -->
                            <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                         </div>
                         <div>
                            Forgot password?
                            <a href="forgot-password.html">Reset It</a>
                         </div>
                      </div>
                      <!-- btn -->
                      <div class="col-12 d-grid">
                        {{-- <button type="submit" class="btn btn-primary">Sign In</button> --}}
                        <button type="submit" class="btn btn-primary">
                            Sign In
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>

                      <!-- link -->
                      <div>
                         Don’t have an account?
                         <a href="register">Sign Up</a>
                      </div>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </section>
 

  {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body"> 
                     <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
