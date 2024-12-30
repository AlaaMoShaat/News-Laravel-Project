   <!-- Top Bar Start -->
   <div class="top-bar">
       <div class="container">
           <div class="row" style="align-items: center; height: 60px;">
               <div class="col-lg-4">
                   <div class="b-ads">
                       @auth
                           <a href="{{ route('frontend.dashboard.profile') }}">
                               <img src="{{ asset(auth()->user()->image) }}"
                                   style="width: 40px; height: 40px; border-radius: 50%;" alt="Profile Picture">
                               <strong style="color: white">Hello, {{ auth()->user()->name }}</strong>
                           </a>
                       @endauth
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="tb-contact">
                       <p><i class="fas fa-envelope"></i>{{ $get_setting->email }}</p>
                       <p><i class="fas fa-phone-alt"></i>{{ $get_setting->phone }}</p>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="tb-menu">
                       @guest
                           <a href="{{ route('register') }}" title="register"><i class="fa fa-user-plus"></i></a>
                           <a href="{{ route('login') }}" title="login"><i class="fa fa-user"></i></a>
                       @endguest
                       @auth
                           <a href="javascript:void(0)" title="sign out"
                               onclick="if(confirm('Do you want to logout')){document.getElementById('formLogout').submit()} return false"><i
                                   class="fas fa-sign-out-alt"></i></a>
                       @endauth

                       <a href="{{ route('frontend.contact.index') }}" title="contact"><i
                               class="fa fa-envelope"></i></a>

                       <form id="formLogout" action="{{ route('logout') }}" method="POST">
                           @csrf
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Top Bar Start -->

   <!-- Brand Start -->
   <div class="brand">
       <div class="container">
           <div class="row align-items-center">
               <div class="col-lg-3 col-md-4">
                   <div class="b-logo">
                       <a href="{{ route('frontend.index') }}">
                           <img src="{{ asset($get_setting->logo) }}" alt="Logo" />
                       </a>
                   </div>
               </div>

               <div class="col-lg-3 col-md-4">
                   <form action="{{ route('frontend.search.index') }}" method="POST">
                       @csrf
                       <div class="b-search">
                           <input name="search" type="text" placeholder="Search" />
                           <button type="submit"><i class="fa fa-search"></i></button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
   <!-- Brand End -->

   <!-- Nav Bar Start -->
   <div class="nav-bar">
       <div class="container">
           <nav class="navbar navbar-expand-md bg-dark navbar-dark">
               <a href="#" class="navbar-brand">MENU</a>
               <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                   <span class="navbar-toggler-icon"></span>
               </button>

               <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                   <div class="navbar-nav mr-auto">
                       <a href="{{ route('frontend.index') }}"
                           class="nav-item nav-link {{ Route::is('frontend.index') ? 'active' : '' }}">Home</a>
                       <div class="nav-item dropdown">
                           <a href="#"
                               class="nav-link dropdown-toggle {{ Route::is('frontend.category.posts') ? 'active' : '' }}"
                               data-toggle="dropdown">Categories</a>
                           <div class="dropdown-menu">
                               @foreach ($categories as $category)
                                   <a href="{{ route('frontend.category.posts', $category->slug) }}"
                                       class="dropdown-item" title="{{ $category->name }}">{{ $category->name }}</a>
                               @endforeach
                           </div>
                       </div>
                       <a href="{{ route('frontend.contact.index') }}"
                           class="nav-item nav-link {{ Route::is('frontend.contact.index') ? 'active' : '' }}">Contact
                           Us</a>
                       @auth
                           <a href="{{ route('frontend.dashboard.profile') }}"
                               class="nav-item nav-link {{ Route::is('frontend.dashboard.profile') ? 'active' : '' }}">My
                               Account</a>
                       @endauth

                   </div>
                   <div class="social ml-auto">
                       <!-- Notification Dropdown -->
                       @auth
                           <a href="" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fas fa-bell"></i>

                               <span id="countNotifications"
                                   class="badge badge-danger">{{ auth()->user()->unreadNotifications()->count() }}</span>

                           </a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                               style="width: 300px;">
                               <h5><a style="width: 100% !important; color: black !important"
                                       href="{{ route('frontend.dashboard.notifications') }}">Notifications</a></h5>

                               @forelse (auth()->user()->unreadNotifications()->take(5)->get()  as $notify)
                                   <div id="push-notification">
                                       <div class="dropdown-item d-flex justify-content-between align-items-center">
                                           <span> Post Comment : {{ substr($notify->data['post_title'], 0, 9) }}...</span>
                                           <a
                                               href="{{ route('frontend.post.show', $notify->data['post_slug']) }}?notify={{ $notify->id }}"><i
                                                   class="fa fa-eye"></i></a>
                                       </div>
                                   </div>


                               @empty

                                   <div class="dropdown-item text-center">No notifications</div>
                               @endforelse
                               @if (auth()->user()->unreadNotifications()->count() > 0)
                                   <a style="width: 50% !important"
                                       href="{{ route('frontend.dashboard.notifications.readAll') }}"
                                       class="dropdown-header">Mark All </a>
                               @endif

                           </div>
                       @endauth


                       <a href="{{ $get_setting->twitter }}" title="twitter" rel="nofollow"><i
                               class="fab fa-twitter"></i></a>
                       <a href="{{ $get_setting->facebook }}" title="facebook" rel="nofollow"><i
                               class="fab fa-facebook-f"></i></a>
                       <a href="{{ $get_setting->instagram }}" title="instagram" rel="nofollow"><i
                               class="fab fa-instagram"></i></a>
                       <a href="{{ $get_setting->youtube }}" title="youtube" rel="nofollow"><i
                               class="fab fa-youtube"></i></a>
                   </div>
               </div>
           </nav>
       </div>
   </div>
   <!-- Nav Bar End -->
