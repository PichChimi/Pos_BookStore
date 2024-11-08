<div class="border-bottom">
    <div class="bg-light py-1">
       <div class="container">
          <div class="row">
             <div class="col-md-6 col-12 text-center text-md-start"><span></span></div>
             <div class="col-6 text-end d-none d-md-block">
               
                <div class="dropdown selectBox">
                  @if (App::getLocale() == 'en')
                        <a class="dropdown-toggle selectValue text-reset" href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false">
                           <span class="me-2" id="language-icon">
                              <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <g clip-path="url(#selectedlang)">
                                    <path d="M0 0.5H16V12.5H0V0.5Z" fill="#012169" />
                                    <path d="M1.875 0.5L7.975 5.025L14.05 0.5H16V2.05L10 6.525L16 10.975V12.5H14L8 8.025L2.025 12.5H0V11L5.975 6.55L0 2.1V0.5H1.875Z" fill="white" />
                                    <path
                                       d="M10.6 7.525L16 11.5V12.5L9.225 7.525H10.6ZM6 8.025L6.15 8.9L1.35 12.5H0L6 8.025ZM16 0.5V0.575L9.775 5.275L9.825 4.175L14.75 0.5H16ZM0 0.5L5.975 4.9H4.475L0 1.55V0.5Z"
                                       fill="#C8102E" />
                                    <path d="M6.025 0.5V12.5H10.025V0.5H6.025ZM0 4.5V8.5H16V4.5H0Z" fill="white" />
                                    <path d="M0 5.325V7.725H16V5.325H0ZM6.825 0.5V12.5H9.225V0.5H6.825Z" fill="#C8102E" />
                                 </g>
                                 <defs>
                                    <clipPath id="selectedlang">
                                       <rect width="16" height="12" fill="white" transform="translate(0 0.5)" />
                                    </clipPath>
                                 </defs>
                              </svg>
                           </span>
                           English
                        </a>
                  @else
                  <a class="dropdown-toggle selectValue text-reset" href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false">
                     <span class="me-2" id="language-icon">
                        <img src="{{ asset('assets/images/logo/flag-cambodia.svg') }}" alt="Cambodian Flag" width="24" height="19">
                        {{-- <svg width="16" height="10" viewBox="0 0 16 10" xmlns="http://www.w3.org/2000/svg">
                           <rect width="16" height="10" fill="#0033A0"/> <!-- Blue field -->
                           <rect y="3" width="16" height="4" fill="#D52B1E"/> <!-- Red field -->
                           <g fill="#FFFFFF">
                               <path d="M8 1.5L9 3H7L8 1.5Z"/> <!-- Central tower spire -->
                               <path d="M5 3L6 4H4L5 3Z"/> <!-- Left tower -->
                               <path d="M10 3L11 4H9L10 3Z"/> <!-- Right tower -->
                               <rect x="6" y="4" width="4" height="2"/> <!-- Central building -->
                               <rect x="5" y="5" width="1" height="2"/> <!-- Left building -->
                               <rect x="10" y="5" width="1" height="2"/> <!-- Right building -->
                           </g>
                       </svg> --}}
                     </span>
                     Khmer
                  </a>
                  @endif
                   

                   <ul class="dropdown-menu">
                      <li>
                        

                         <a class="dropdown-item" href="{{ route('lang', ['locale' => 'en']) }}">
                            <span class="me-2">
                               <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <g clip-path="url(#selectedlang)">
                                     <path d="M0 0.5H16V12.5H0V0.5Z" fill="#012169" />
                                     <path d="M1.875 0.5L7.975 5.025L14.05 0.5H16V2.05L10 6.525L16 10.975V12.5H14L8 8.025L2.025 12.5H0V11L5.975 6.55L0 2.1V0.5H1.875Z" fill="white" />
                                     <path
                                        d="M10.6 7.525L16 11.5V12.5L9.225 7.525H10.6ZM6 8.025L6.15 8.9L1.35 12.5H0L6 8.025ZM16 0.5V0.575L9.775 5.275L9.825 4.175L14.75 0.5H16ZM0 0.5L5.975 4.9H4.475L0 1.55V0.5Z"
                                        fill="#C8102E" />
                                     <path d="M6.025 0.5V12.5H10.025V0.5H6.025ZM0 4.5V8.5H16V4.5H0Z" fill="white" />
                                     <path d="M0 5.325V7.725H16V5.325H0ZM6.825 0.5V12.5H9.225V0.5H6.825Z" fill="#C8102E" />
                                  </g>
                                  <defs>
                                     <clipPath id="selectedlang">
                                        <rect width="16" height="12" fill="white" transform="translate(0 0.5)" />
                                     </clipPath>
                                  </defs>
                               </svg>
                            </span>
                            English
                         </a>

                      </li>
                      <li>

                        <a class="dropdown-item" href="{{ route('lang', ['locale' => 'kh']) }}">
                           <span class="me-2">
                              <img src="{{ asset('assets/images/logo/flag-cambodia.svg') }}" alt="Cambodian Flag" width="24" height="19">
                               {{-- <svg width="16" height="10" viewBox="0 0 16 10" xmlns="http://www.w3.org/2000/svg">
                                   <rect width="16" height="10" fill="#0033A0"/> <!-- Blue field -->
                                   <rect y="3" width="16" height="4" fill="#D52B1E"/> <!-- Red field -->
                                   <g fill="#FFFFFF">
                                       <path d="M8 1.5L9 3H7L8 1.5Z"/> <!-- Central tower spire -->
                                       <path d="M5 3L6 4H4L5 3Z"/> <!-- Left tower -->
                                       <path d="M10 3L11 4H9L10 3Z"/> <!-- Right tower -->
                                       <rect x="6" y="4" width="4" height="2"/> <!-- Central building -->
                                       <rect x="5" y="5" width="1" height="2"/> <!-- Left building -->
                                       <rect x="10" y="5" width="1" height="2"/> <!-- Right building -->
                                   </g>
                               </svg> --}}
                           </span>
                           Khmer
                       </a>
                       
                     
                      </li>
                   </ul>
                </div>

             </div>
          </div>
       </div>
    </div>
    <div class="py-5">
       <div class="container">
          <div class="row w-100 align-items-center gx-lg-2 gx-0">
             <div class="col-xxl-2 col-lg-3 col-md-6 col-5">
                <a class="navbar-brand d-none d-lg-block" href="{{ route('page.index') }}">
                   <img src="assets/images/logo/freshcart-logo.svg" alt="eCommerce HTML Template"/>
                </a>
                <div class="d-flex justify-content-between w-100 d-lg-none">
                   <a class="navbar-brand" href="{{ route('page.index') }}">
                      <img src="assets/images/logo/freshcart-logo.svg" alt="eCommerce HTML Template"/>
                   </a>
                </div>
             </div>
             <div class="col-xxl-5 col-lg-5 d-none d-lg-block">
                {{-- <form action="#">
                   <div class="input-group">
                      <input class="form-control rounded" type="search" placeholder="Search for products" />
                      <span class="input-group-append">
                         <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end" type="button">
                            <svg
                               xmlns="http://www.w3.org/2000/svg"
                               width="16"
                               height="16"
                               viewBox="0 0 24 24"
                               fill="none"
                               stroke="currentColor"
                               stroke-width="2"
                               stroke-linecap="round"
                               stroke-linejoin="round"
                               class="feather feather-search">
                               <circle cx="11" cy="11" r="8"></circle>
                               <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                         </button>
                      </span>
                   </div>
                </form> --}}
             </div>
             <div class="col-md-2 col-xxl-3 d-none d-lg-block">
                <!-- Button trigger modal -->
                {{-- <button type="button" class="btn btn-outline-gray-400 text-muted" data-bs-toggle="modal" data-bs-target="#locationModal">
                   <i class="feather-icon icon-map-pin me-2"></i>
                   Location
                </button> --}}
             </div>
             <div class="col-lg-2 col-xxl-2 text-end col-md-6 col-7">
                <div class="list-inline">
                   <div class="list-inline-item me-5">
                      <a href="#" class="text-muted position-relative">
                         <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-heart">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                         </svg>
                         <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                            5
                            <span class="visually-hidden">unread messages</span>
                         </span>
                      </a>
                   </div>

                    @guest
  
                        <div class="list-inline-item me-5 ">
                           {{-- <a href="#!" class="text-muted" data-bs-target="#userModal"> --}}
                           <a href="login" class="text-muted" data-bs-target="#userModal">
                              <svg
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="20"
                                 height="20"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="feather feather-user">
                                 <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                 <circle cx="12" cy="7" r="4"></circle>
                              </svg>
                           </a>

                        </div>

                        @else
                            
                              <div class="dropdown list-inline-item me-5">
                                 <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../assets/images/avatar/avatar-1.jpg" alt="" class="avatar avatar-md rounded-circle" />
                                 </a>
                              
                                 <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="lh-1 px-5 py-4 border-bottom">
                                       <h5 class="mb-1 h6">{{ Auth::user()->name }}</h5>
                                       <small>{{ Auth::user()->email }}</small>
                                    </div>
                              
                                    <ul class="list-unstyled px-1">
                                      
                                      

                                       <li>
                                          <a class="dropdown-item" href="#">Profile</a>
                                       </li>
                                 
                                    </ul>
                                    <div class="border-top px-5 py-3">
                                       <a href="#" onclick="event.preventDefault(); confirmLogout();">
                                          Log Out
                                    </a>
            
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                       @csrf
                                    </form>
                                    </div>
                                 </div>
                              </div>

                           @endguest
            
                              <script>
                                 function confirmLogout() {
                                    // Show confirmation dialog
                                    if (confirm('Are you sure you want to log out?')) {
                                       // If the user clicks "Yes", submit the form
                                       document.getElementById('logout-form').submit();
                                    }
                                    // If the user clicks "No", do nothing (the form won't be submitted)
                                 }
                           </script>

               
                   <div class="list-inline-item me-5 me-lg-0">
                      <a class="text-muted position-relative" href="#"aria-controls="offcanvasRight">
                         <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-shopping-bag">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                         </svg>
                         <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                            1
                            <span class="visually-hidden">unread messages</span>
                         </span>
                      </a>
                   </div>

                   

                   <div class="list-inline-item d-inline-block d-lg-none">
                      <!-- Button -->
                      <button
                         class="navbar-toggler collapsed"
                         type="button"
                         data-bs-toggle="offcanvas"
                         data-bs-target="#navbar-default"
                         aria-controls="navbar-default"
                         aria-label="Toggle navigation">
                         <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-text-indent-left text-primary" viewBox="0 0 16 16">
                            <path
                               d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                         </svg>
                      </button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light navbar-default py-0 pb-lg-4" aria-label="Offcanvas navbar large">
       <div class="container">
          <div class="offcanvas offcanvas-start" tabindex="-1" id="navbar-default" aria-labelledby="navbar-defaultLabel">
             <div class="offcanvas-header pb-1">
                <a href="index.html"><img src="assets/images/logo/freshcart-logo.svg" alt="eCommerce HTML Template" /></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
             </div>
             <div class="offcanvas-body">
                <div class="d-block d-lg-none mb-4">
                   <form action="#">
                      <div class="input-group">
                         <input class="form-control rounded" type="search" placeholder="Search for products" />
                         <span class="input-group-append">
                            <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end" type="button">
                               <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  width="16"
                                  height="16"
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  class="feather feather-search">
                                  <circle cx="11" cy="11" r="8"></circle>
                                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                               </svg>
                            </button>
                         </span>
                      </div>
                   </form>
                   <div class="mt-2">
                      <button type="button" class="btn btn-outline-gray-400 text-muted w-100" data-bs-toggle="modal" data-bs-target="#locationModal">
                         <i class="feather-icon icon-map-pin me-2"></i>
                         Pick Location
                      </button>
                   </div>
                </div>
                
                <div>
                   <ul class="navbar-nav align-items-center">
                      <li class="nav-item dropdown w-100 w-lg-auto">
                         <a class="nav-link" href="{{ route('page.index') }}">{{ __('globle.home') }}</a>
                      </li>

                      <li class="nav-item dropdown w-100 w-lg-auto">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">System</a>
                        <ul class="dropdown-menu">
                           <li><a class="dropdown-item" href="{{ route('user.index') }}">User</a></li>
                           <li><a class="dropdown-item" href="{{ route('role.index') }}">Role</a></li>
                           
                        </ul>
                     </li>

                    
                      <li class="nav-item dropdown w-100 w-lg-auto">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Product</a>
                        <ul class="dropdown-menu">
                           <li><a class="dropdown-item" href="{{ route('book.index') }}">Book</a></li>
                           <li><a class="dropdown-item" href="{{ route('genres.index') }}">Genres</a></li>
                           <li><a class="dropdown-item" href="{{ route('author.index') }}">Authors</a></li>
                        </ul>
                     </li>

                     <li class="nav-item dropdown w-100 w-lg-auto">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Inventory</a>
                        <ul class="dropdown-menu">
                           <li><a class="dropdown-item" href="{{ route('stock.index') }}">Stock</a></li>
                           <li><a class="dropdown-item" href="{{ route('supplier.index') }}">Supplier</a></li>
                        </ul>
                     </li>

                      <li class="nav-item dropdown w-100 w-lg-auto">
                         <a class="nav-link " href="{{ route('page.sale') }}">Sale</a>
                      </li>
                     
                   </ul>
                </div>
             </div>
          </div>
       </div>
    </nav>
 </div>