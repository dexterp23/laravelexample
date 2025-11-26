<?php
header("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1250">
    <title>Page Not Found (404)</title>
    <style type="text/css">
        body {
            text-align: center;
            font-weight: bold;
            font-family: sans-serif;
        }

        h1 {
            font-size: 20em;
            color: #CCC;
            margin-bottom: 0px;
        }

        button {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 6px;
            background-color: #428BCA;
            border-color: #357EBD;
            color: white;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0);
        }

            button:hover {
                background-color: #3276B1;
                border-color: #285E8E;
            }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Sorry! The requested page does not exist.</p>
    <button onclick="window.location = '/';">
        Click To Visit Our Home Page
    </button>
</body>
</html>
