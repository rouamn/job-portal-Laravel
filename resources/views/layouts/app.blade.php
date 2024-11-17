<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f1f2f6;
            margin: 0;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        .form-control {
            border: none;
            border-bottom: 2px solid #ddd;
            border-radius: 0;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #6c63ff;
            box-shadow: none;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 10px 20px;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
        }
        .card-footer {
            text-align: center;
            background-color: transparent;
        }
        .icon-placeholder {
            font-size: 40px;
            background-color: #ddd;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }
        body, .container {
            max-width: 100%;
            overflow-x: hidden;
        }

        @media (max-width: 576px) {
            .card {
                padding: 20px;
                max-width: 100%;
            }
            .navbar {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>


    <div class="container">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
