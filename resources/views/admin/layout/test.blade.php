<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css','resources/js/bootstrap.js'])

    <style>
        body{
            background-color: #f8f9fa;
        }

        .navbar .dropdown:hover>.dropdown-menu {
            display: block;
        }

        .navbar .dropdown>.dropdown-toggle:active {
            /*Without this, clicking will make it sticky*/
            pointer-events: none;
        }

        .navbar .nav-item.active>div {
            background-color: #e9ecef;
            border-radius: 10px;
        }

        .navbar .nav-item button {
            font-weight: 500;
            color: grey;
        }

        .navbar .nav-item button:active {
            border-color: transparent;
        }

        .navbar .nav-item button:hover {
            color: #0d6efd;
        }

        .navbar .nav-item.active button {
            font-weight: 500;
            color: #0d6efd;
        }

        .navbar .dropdown-menu {
            animation: fadeUp 0.1s;
        }

        .navbar .dropdown-menu .dropdown-item {
            border-radius: 10px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @yield('css')
</head>

<body>
    <nav class="navbar navbar-expand-lg px-1 bg-white py-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-3">
                    <li class="nav-item active">
                        <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">
                                Dropdown button
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Action</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">
                                Dropdown button
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Action</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        @yield('content')
    </div>
    <div class="footer bg-dark text-white fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2021 Admin Panel</p>
                </div>
            </div>
        </div>
    </div>
    @yield('js')
</body>

</html>