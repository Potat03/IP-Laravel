<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: #fff;
            padding-top: 20px;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: darkred;
            color: #fff;
        }

        .content {
            padding: 20px;
            background-color: #fff;
            min-height: 100vh;
        }

        .nav-link:hover,
        .nav-item:hover {
            color: darkred !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#!">Profile Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!">Log Out</a>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <h1>Welcome, [Customer Name]</h1>
                <p>Here you can manage your profile information, view your orders, and update your account settings.</p>
                <!-- Add more content here as needed -->
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
