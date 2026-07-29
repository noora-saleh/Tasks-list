<?php
session_start();

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
$password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "todoo");

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $check = $conn->prepare("SELECT * FROM login WHERE username=? OR email=?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $result = $check->get_result();

    if($result->num_rows > 0){
        $error = "اسم المستخدم أو البريد موجود مسبقًا!";
    } else {
        $insert = $conn->prepare("INSERT INTO login (username, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $username, $email, $password);
        if($insert->execute()){
            $_SESSION['userid'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            header("Location: addTask.php");
            exit;
        } else {
            $error = "حدث خطأ أثناء التسجيل!";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>إنشاء حساب جديد</title>
<style>
body {
    display: flex;
    flex-direction: column;
    align-items: center;
    background:#fffcf5;
    margin:0;
    padding-top:100px;
    min-height:100vh;
}
.container {
    width: 600px;
    background: #babde2;
    padding: 30px;
    border-radius: 50px;
    box-shadow: 0 0 20px rgba(0,0,0,0.4);
}
.title {
    font-size: 35px;
    font-weight: 800;
    text-align: center;
    color: #374375;
    margin-bottom: 30px;
}
.input-box {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}
.input-box label {
    margin-bottom: 5px;
}
.input-box input {
    height: 45px;
    border-radius: 50px;
    padding-left: 15px;
    border: 1px solid #a5a2a0;
    font-size: 16px;
    background: #fffcf5;
}
button {
    width: 100%;
    padding: 10px;
    border-radius: 50px;
    background: #374375;
    border: none;
    color: #E4D8C8;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
}
button:hover {
    background: #E4D8C8;
    color: #374375;
}
.error-msg {
    background: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 15px;
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
    border: 1px solid #f5c6cb;
}
.login-link {
    margin-top: 15px;
    text-align: center;
    font-size: 16px;
}
.login-link a {
    color: #374375;
    text-decoration: underline;
    font-weight: bold;
}
.login-link a:hover {
    color: #374375;
}
</style>
</head>
<body>

<div class="container">
<div class="title">إنشاء حساب جديد</div>

<?php if(!empty($error)) echo "<div class='error-msg'>$error</div>"; ?>

<form action="" method="post">
<div class="input-box">
<label>اسم المستخدم</label>
<input type="text" name="username" required>
</div>

<div class="input-box">
<label>البريد الإلكتروني</label>
<input type="email" name="email" required>
</div>

<div class="input-box">
<label>كلمة المرور</label>
<input type="password" name="password" required>
</div>

<button type="submit" name="register">إنشاء الحساب</button>
</form>

<div class="login-link">
هل لديك حساب سابق؟ <a href="zuhair-2.php">تسجيل الدخول</a>
</div>

</div>
</body>
</html>
