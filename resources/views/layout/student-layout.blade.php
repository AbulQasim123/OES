<!doctype html>
<html lang="en">

<head>
    <title>Student OES</title>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script type="text/javascript" src="{{ asset('assets\jquery\jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/customscript.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <h1><a href="/admin/dashboard" class="logo">Welcome {{Auth::user()->name}}</a></h1>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="/dashboard"><span class="fa fa-book mr-3"></span> Dashboard</a>
                </li>
                <li>
                    <a href="/logout"><span class="fa fa-sign-out mr-3"></span> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            @yield('student-space')
        </div>
    </div>

    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>