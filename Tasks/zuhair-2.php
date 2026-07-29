<?php
session_start();
$errorMessage = "";

if(isset($_POST["save"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "","todoo");
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $q1 = $conn->prepare("SELECT * FROM login WHERE username =? AND password =?");
    $q1->bind_param("ss", $username, $password);
    $q1->execute();

    $result = $q1->get_result(); 
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $_SESSION["userid"] = $row["id"];
        $_SESSION["username"] = $row["username"];

        header("location:addTask.php"); // الانتقال إلى صفحة المهام
        exit;
    } else {
        $errorMessage = "اسم المستخدم أو كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول</title>
    <style>
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

        .cta {
         border: none;
         border-radius: 50px;
         padding: 10px;
         width: 90px;
         font-weight: 600;
         background-color: #374375;
         color: #fffcf5;
         }
        .cta:hover {
         background-color: #babde2;
         color: white;
         transition: 0.3s; 
        }

        .navBtn {
         border: none;
         border-radius: 50px;
         padding: 10px;
         width: 90px; 
        font-weight: 600;
         background-color: #babde2;
         color: white; 
        }

        .navBtn:hover {
         background-color: #374375;
         color: #fffcf5;
         transition: 0.3s; 
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fffcf5;
            margin: 0;
            padding-top: 100px;
            min-height: 100vh;
        }
        .container {
            width: 600px;
            background: #babde2;
            padding: 30px 30px 50px 30px;
            border-radius: 50px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }
        .title {
            font-size: 35px;
            font-weight: 800;
            text-align: center;
            color: #374375;
            margin-bottom: 30px;
        }
        .user-details {
            display: flex;
            font-size: 20px;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px 0 12px 0;
        }

        .input-box { 
        margin-bottom: 15px;
         width: calc(50% - 20px); 
        }

        .input-box span {
         display: block;
         font-weight: 500;
         margin-bottom: 5px; }

        .input-box input {
            height: 45px; 
            width: 100%;
            outline: none;
             border: 1px solid #ffffffff;
            padding-left: 15px;
             font-size: 16px;
            border-bottom-width: 2px;
             border-radius: 50px;
            background-color: #fffcf5;
        }
        .input-box input:focus,
        .input-box input:valid { 
            border-color: black; 
        }

        .button {
             height: 45px;
              margin: 30px 0;
             display: flex;
              justify-self: center;
             }

        button {
        border: none;
         border-radius: 50px;
         padding: 10px;
            width: 90px;
         font-weight: 600; 
        background-color: #374375;
     color:#E4D8C8;
            display: flex;
         justify-content: center; 
        font-size: 20px;
        }
        button:hover {
         background-color: #E4D8C8; 
         transition: 0.3s; 
         color: #374375;
         }
        .error-msg {
            background-color: #f8d7da;
             color: #721c24;
            padding: 12px;
             border-radius: 15px; 
             text-align: center;
            font-weight: bold;
             margin-bottom: 15px;
              border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>

<nav>
    <ul>
        <li><a href="createacc.php" class="cta">دخول / تسجيل</a></li>
        <li><a href="wellcom.php" class="navBtn">الترحيب</a></li>
        <li><a href="addTask.php" class="navBtn">المهام</a></li>
        <li><a href="profile.php" class="navBtn">الملف الشخصي</a></li>
    </ul>
</nav>

<div class="title">تسجيل دخول</div>

<div class="container">
    <?php if (!empty($errorMessage)): ?>
        <div class="error-msg"><?= $errorMessage ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="user-details">
            <div class="input-box">
                <span>اسم المستخدم</span>
                <input type="text" id="usernameinput" name="username" placeholder="ادخل اسم المستخدم" required>
            </div>
            <div class="input-box">
                <span>كلمة المرور</span>
                <input type="password" name="password" id="passwordinput" placeholder="ادخل كلمة المرور" required>
            </div>
        </div>
        <div class="button">
            <button type="submit" name="save">تسجيل</button>
        </div>
    </form>
</div>

</body>
</html>
