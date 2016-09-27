<!doctype html>
<html lang="fa" dir="fa">
<head>
    <meta charset="UTF-8">
    <title>Ashojash registration</title>
</head>
<body style="text-align:right; direction:rtl;font-size: 15px">
<div>
    <h3 style="text-align: center">
        ثبت نام آشوجاش
    </h3>

    <h4 style="text-align: center">
        تنها یک گام با دنیایی از غذاها فاصله دارید
    </h4>

    <p>
        {{$user->name}} عزیز،
    </p>

    <p>
        از ثبت نام شما در آشوجاش متشکریم. روی لینک زیر کلیک کنید تا حساب کاربریان فعال شود.<br>
    </p>
    <a href="{{url("auth/confirm/{$user->email_token}")}}">لینک فعال سازی</a>

    <p>اگر لینک بالا کار نمی‌کند لینک زیر را در مرورگر خود باز کنید.</p>

    <p>
        {{url("auth/confirm/{$user->email_token}")}}
    </p>

    <p>
        با احترام،<br>
        تیم آشوجاش
    </p>
</div>
</body>
</html>