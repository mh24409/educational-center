<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Chivo+Mono&display=swap');
    </style>
    <style>
        body {
            background-image: url({{ asset('assets/images/background/error-bg.jpg') }});
            background-position: center;
            background-repeat: none;
            background-size: cover;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 95vh;
        }

        .link {
            border: solid;
            position: relative;
            padding: 10px;
            border-radius: 20px;
            transition: 5s ;
        }

        .link h3 {
            font-family: 'Chivo Mono', monospace;
            font-size: 50px;
        }

        .link::before {
            content: "";
            width: 5px;
            height: 100%;
            background-color: rgb(0, 48, 84);
            position: absolute;
            right: -50px;
            top: 0px;
        }

        .link::after {
            content: "";
            width: 5px;
            height: 100%;
            background-color: rgb(0, 48, 84);
            position: absolute;
            left: -50px;
            top: 0px;
        }

        .link:hover {
            color: white;
        }

        .link:hover::after {
            animation: animateafter 0.9s linear forwards;
            background-color: rgb(0, 48, 84);
            z-index: -1;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;

        }

        .link:hover::before {
            animation: animatebefore 0.9s linear forwards;
            background-color: rgb(0, 48, 84);
            z-index: -1;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        @keyframes animateafter {
            0% {
                left: -50px;
                top: 0px;
            }

            50% {
                left: 0px;
                width: 50%;
                height: 100%;
            }

            100% {
                left: 0px;
                width: 50%;
                height: 100%;
            }

        }

        @keyframes animatebefore {
            0% {
                right: -50px;
                top: 0px;
            }

            50% {
                right: 0px;
                width: 50%;
                height: 100%;
            }

            100% {
                right: 0px;
                width: 50%;
                height: 100%;
            }

        }

        .btn-admin {
            position: absolute;
            bottom: -50%;
            right: 50%;
            width: 150px;
            transform: translateX(75px);
            border: solid;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            color: black
        }

        .btn-admin:hover {
            transition: 0.5s;
            background-color: rgb(0, 48, 84);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="link">
            <h3>Educational Center</h3>
            <a class="btn-admin" href="{{ route('admin.login') }}"><span>Login As Admin</span></a>

        </div>
    </div>
</body>

</html>
