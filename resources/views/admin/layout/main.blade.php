<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css','resources/js/bootstrap.js'])

    <style>
        body {
            background-color: #f8f9fa;
        }

        main{
            display: flex;
            min-height: 100vh;
        }

        .main-sidebar .btn:active {
            border-color: transparent;
        }
    </style>
    @yield('css')
</head>

<body>
    <main>
        <div class="flex-shrink-0 p-3 bg-white d-flex flex-column main-sidebar" style="width: 270px;">
            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <span class="fs-5 fw-semibold text-center">Collapsible</span>
            </a>
            <ul class="list-unstyled ps-0 d-flex flex-column flex-fill">
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        Home
                    </button>
                    <div class="collapse" id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                            <li><a href="#" class="link-dark rounded text-decoration-none">Overview</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Updates</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Reports</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                        Dashboard
                    </button>
                    <div class="collapse" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                            <li><a href="#" class="link-dark rounded text-decoration-none">Overview</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Weekly</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Monthly</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Annually</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                        Orders
                    </button>
                    <div class="collapse" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                            <li><a href="#" class="link-dark rounded text-decoration-none">New</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Processed</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Shipped</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Returned</a></li>
                        </ul>
                    </div>
                </li>
                <li class="border-top mt-auto"></li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                        Hi, Husky
                    </button>
                </li>
            </ul>
        </div>
        <div class="flex-fill">
            <div class="p-5">
                @yield('content')
            </div>
        </div>
    </main>
    @yield('js')

    <script>
        //collapse other menu when one menu is clicked
        let btns = document.querySelectorAll('.main-sidebar .btn-toggle');
        btns.forEach(btn => {
            btn.addEventListener('click', function() {
                btns.forEach(b => {
                    if (b !== btn) {
                        //click other btns to toggle collapse
                        if(b.getAttribute('aria-expanded') === 'true'){
                            b.click();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>