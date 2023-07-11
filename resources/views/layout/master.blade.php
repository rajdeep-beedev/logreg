<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"
            type="text/css" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
            type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    </head>
    
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="#">{{(isset($users))?('Hi, '.$users->first_name.' '.$users->last_name):''}}</a>
    
                <div class="nav-link">
                    <!-- Button trigger modal -->
                    @if(auth()->user()) 
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                             Profile
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{url('/edit-profile').'/'.Auth::user()->id}}">Edit Profile</a></li>
                              <li><a class="dropdown-item" href="{{url('/logout')}}">logout</a></li>
                            </ul>
                          </div>
                    @else
                        <a href="#signup" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Login">Login</a>
                        <a class="btn btn-primary" href="#signup" data-bs-toggle="modal" data-bs-target="#Signup">Sign Up</a>
                    @endif
                </div>
        </nav>
        <!-- Masthead-->
    <div class="container">
        @yield('content')
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      </body>
</html>