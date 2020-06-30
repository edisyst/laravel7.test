<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

    <title>GALLERY ADMIN</title>
    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/css/fontawesome.css" type="text/css">
    <link rel="stylesheet" href="/css/sb-admin.css">
    <link rel="stylesheet" href="/datatables/dataTables.bootstrap4.css">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>



<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.html">Start Bootstrap</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div id="navbarTeoricamenteLaterale" class="nav">

                    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                                <a class="nav-link" href="{{route('admin')}}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span class="nav-link-text">ADMIN</span>
                                </a>
                            </li>
                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Users">
                                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUsers" data-parent="#collapseUsers">
                                    <i class="fa fa-fw fa-wrench"></i>
                                    <span class="nav-link-text">Users</span>
                                </a>
                                <ul class="sidenav-second-level collapse" id="collapseUsers">
                                    <li>
                                        <a href="{{route('user-list')}}">User list</a>
                                    </li>
                                    <li>
                                        <a href="{{route('users.create')}}">New user</a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                                <a class="nav-link" href="tables.html">
                                    <i class="fa fa-fw fa-file-image"></i>
                                    <span class="nav-link-text">Albums Categories</span>
                                </a>
                            </li>

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-fw fa-book"></i>
                                    <span class="nav-link-text">Albums</span>
                                </a>
                            </li>
                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-portrait"></i>
                                    <span class="nav-link-text">Pictures</span>
                                </a>
                            </li>
                            </ul>

                    <ul class="navbar-nav sidenav-toggler">
                        <li class="nav-item">
                            <a class="nav-link text-center" id="sidenavToggler">
                                <i class="fa fa-fw fa-angle-left"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-left mr-auto">
                        <li class="nav-item">
                            <a class="nav-link text-left">
                                <i class="fa fa-fw fa-home">HOME</i>
                            </a>
                        </li>

                    </ul>
                    <ul class="navbar-nav navbar-right ml-auto">

                        <li class="nav-item">
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <a class="nav-link"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="{{route('logout')}}">
                                <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                        </li>
                    </ul>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>Start Bootstrap
                </div>
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin')}}">Admin Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">{{Route::currentRouteName()}}</li>
                </ol>
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
        <footer class="sticky-footer">
            <div class="container">
                <div class="text-center">
                    <small>Copyright © Laragallery {{date('Y')}}</small>
                </div>
            </div>
        </footer>
    </div>
</div>



@section('footer')
    <!-- Bootstrap core JavaScript-->
    <script src="{{url('/')}}/jquery/jquery.min.js"></script>
    <script src="{{url('/')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{url('/')}}/jquery-easing/jquery.easing.min.js"></script>
    <script src="{{url('/')}}/datatables/jquery.dataTables.js"></script>
    <script src="{{url('/')}}/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{url('/')}}/js/sb-admin.js"></script>
    <script src="{{url('/')}}/js/sb-admin-datatables.js"></script>
@show

</body>
</html>







