<?php
session_start();
if(isset($_SESSION['userid'])){
    header("Location:wellcom.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ادارة مهامك</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(#fffcf5, #fffcf5);
            margin: 0;
            padding-top: 30px;
            font-family: "Tahoma", sans-serif;
            height: 100vh;
            justify-content: center;
        }

        nav {
            background-color: #374375;
            padding: 10px;
            font-size: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
        }

        ul {
            margin-top: 0;
            list-style: none;
            display: flex;
            gap: 10px;
            direction: rtl;
            justify-content: space-around;
        }

        a {
            text-decoration: none;
            color: #E4D8C8;
        }

        .cta, .new, .navBtn {
            border: none;
            border-radius: 50px;
            padding: 10px;
            width: 120px;
            font-weight: 600;
            text-align: center;
            
        }

        .cta, .new {
            background-color: #374375;
            color: #fffcf5;
        }

        .cta:hover, .new:hover {
            background-color: #babde2;
            color: white;
            transition: 0.3s;
        }

        .navBtn {
            background-color: #babde2;
            color: white;
        }

        .navBtn:hover {
            background-color: #babde2;
            color: #374375;
            transition: 0.3s;
        }

        .con {
            text-align: center;
            margin-top: 120px;
        }

        .con h1 {
            font-size: 36px;
            color: #374375;
            margin-bottom: 10px;
        }

        .con h1 span {
            color: #babde2;
            font-weight: bold;
        }

        .con p {
            font-size: 20px;
            color: #374375;
            margin-top: 5px;
            margin-bottom: 100px;
        }

        .new2 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="createacc.php" class="cta">تسجيل الدخول</a></li>
            <li><a href="wellcom.php" class="navBtn">الترحيب</a></li>
            <li><a href="addTask.php" class="navBtn">المهام</a></li>
            <li><a href="profile.php" class="navBtn">الملف الشخصي</a></li>
        </ul>
    </nav>

    <div class="con">
    <h1>مرحبا بكم في موقع <span>ادارة مهامك</span></h1>
    <p>لنجعل قائمة مهامك نظيفة ومرتبة معا</p>

    <!-- تسجيل مستخدم جديد -->
    <a href="createacc.php" class="cta">إنشاء حساب جديد</a><br><br><br><br>

    <!-- تسجيل مستخدم موجود -->
    <a href="zuhair-2.php" class="new">تسجيل الدخول</a>
</div>


</body>
</html>
