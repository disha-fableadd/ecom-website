<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6e7e8a, #1e2024);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            overflow: hidden;
        }

        .error-container {
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px;
            transition: transform 0.3s ease-out, opacity 0.3s ease;
        }

        .error-container:hover {
            transform: translateY(-10px);
            opacity: 0.9;
        }

        h1 {
            font-size: 150px;
            color: #D19C97 !important;
            margin: 0;
            letter-spacing: 5px;
            animation: fadeIn 1s ease-in-out;
        }

        p {
            font-size: 20px;
            color: #333;
            margin: 20px 0;
            animation: fadeIn 1.5s ease-in-out;
        }

        a {
            font-size: 18px;
            color: #fff;
            text-decoration: none;
            padding: 15px 30px;
            border: 2px solid  #D19C97 ;
            border-radius: 30px;
            background-color:  #D19C97 ;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s ease;
            animation: fadeIn 2s ease-in-out;
        }

        a:hover {
            background-color: transparent;
            color: #D19C97 ;
            transform: translateY(-5px);
        }

        .btn-container {
            margin-top: 30px;
        }

        /* Animation for fading in */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Add a background shape */
        .background-shape {
            position: absolute;
            top: 0;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: pulse 5s infinite ease-in-out;
            transform: translateX(-50%);
            z-index: -1;
        }

        @keyframes pulse {
            0% {
                transform: translateX(-50%) scale(1);
            }
            50% {
                transform: translateX(-50%) scale(1.2);
            }
            100% {
                transform: translateX(-50%) scale(1);
            }
        }

    </style>
</head>
<body>

<div class="background-shape"></div>

<div class="error-container">
    <h1>404</h1>
    <p>Oops! The page you are looking for doesn't exist.</p>
    <div class="btn-container">
        <a href="{{ route('home') }}">Go back to Home</a>
    </div>
</div>

</body>
</html>
