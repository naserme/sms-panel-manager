<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('jalalidatepicker/jalalidatepicker.min.css') }}">

    <style>
        :root {
            --bg: #6b7280;
            /* خاکستری ملایم */
            --card: #ffffff;
            --muted: #6b7280;
            --accent: #2563eb;
            /* آبی پررنگ */
            --success: #16a34a;
            --danger: #ef4444;
            --glass: rgba(255, 255, 255, 0.06);
            --radius: 12px;
        }

        html,
        body {
            height: 100%;
            margin: 10;
            font-family: "iran-sans";
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: linear-gradient(180deg, var(--bg), #575757 120%);
            color: #111827;
            direction: rtl;
        }

        .container {
            background: var(--card);
            padding: 22px;
            border-radius: var(--radius);
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.3);
            width: 95%;
            max-width: 420px;
            margin: 28px auto;
            text-align: center;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .container:focus-within,
        .container:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(2, 6, 23, 0.35);
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        /* --- دکمه و منو --- */
        .menu-wrapper {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .menu-btn {
            background: #007bff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }

        .menu-content {
            display: none;
            position: absolute;
            top: 110%;
            right: 0;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            width: 250px;
        }

        @media (min-width: 768px) {
            .menu-wrapper:hover .menu-content {
                display: block;
            }
        }

        /* --- modal موبایل --- */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 200;
        }

        .my-link {
            color: inherit;
            /* رنگ متن والد رو می‌گیره */
            text-decoration: none;
            /* خط زیر رو حذف می‌کنه */
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
        }

        .logout-form {
            display: inline-block;
            width: 140px;
        }

        .logout-btn {
            display: inline-block;
            width: 100%;
            background: var(--danger);
            border-radius: 10px;
            padding: 10px;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color .12s ease;
        }

        .logout-btn:hover {
            background: #dc2626;

        }

        @font-face {
            font-family: 'iran-sans';
            src:
                url('/fonts/fonnts.com-IRAN_Sans_Regular.ttf') format('ttf');
            font-weight: normal;
            font-style: normal;
        }
        * {
            font-family: "MyCustomFont", cursive;
            letter-spacing: 0 !important;
        }
    </style>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('jalalidatepicker/jalalidatepicker.min.js') }}"></script>
    <script>
        jalaliDatepicker.startWatch({
            // minDate: "1403/01/01",
            // maxDate: "1404/12/29",
            Date: true,
            hideAfterChange: true,
            dayRendering: function(dayOptions, input) {
                // می‌تونی اینجا روز خاصی رو هایلایت کنی
                return dayOptions;
            }
        });
    </script>

    <!-- موبایل modal -->
    <div id="mobileModal" class="modal">
        <div class="modal-content">
            <span onclick="closeMobileMenu()" style="cursor:pointer;float:left;font-weight:bold">X</span>
            <h3>پیام / اعتبار</h3>
            <input type="text" placeholder="افزایش اعتبار">
            <input type="text" placeholder="ارسال پیام">
            <button>ثبت</button>
        </div>
    </div>



    @yield('content')

    <script>
        function openMobileMenu() {
            if (window.innerWidth < 768) {
                document.getElementById('mobileModal').style.display = 'flex';
            }
        }

        function closeMobileMenu() {
            document.getElementById('mobileModal').style.display = 'none';
        }
    </script>
</body>

</html>