<?php
session_start();

if (!isset($_SESSION["userid"])) {
    header("location:createacc.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "todoo");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION["userid"];
$userQuery = $conn->prepare("SELECT username FROM login WHERE id=?");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

$statsQuery = $conn->prepare("
    SELECT
        SUM(status='pending') AS pending
    FROM task
    WHERE user_id=?
");
$statsQuery->bind_param("i", $userId);
$statsQuery->execute();
$stats = $statsQuery->get_result()->fetch_assoc();

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location:createacc.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>الملف الشخصي</title>
<style>
body {
    margin: 0;
    background-color: #fffcf5;
    font-family: cairo, sans-serif;
}

/* نافبار */
nav {
    background-color: #374375;
    padding: 10px;
    font-size: 25px;
}

ul {
    margin: 10px 0 0 0;
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


/* بقية أزرار النافبار */
.navBtn {
    border: none;
    border-radius: 50px;
    padding: 7px;
    width: 90px;
    font-weight: 600;
    background-color: #babde2;
    color: white;
}

.navBtn:hover {
    transition: 0.3s;
    background-color: #374375;
    color: #fffcf5;
}

/* بطاقة الملف الشخصي */
.Profile-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 80px auto;
    width: 400px;
    background-color: #babde2;
    padding: 30px;
    border-radius: 50px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
}

/* الأفاتار */
.avatar {
    width: 80px;
    height: 80px;
    background-color: #fffcf5;
    border-radius: 50%;
    margin-bottom: 15px;
    font-size: 40px;
    line-height: 80px;
    text-align: center;
    color: #374375;
    font-weight: bold;
}

/* اسم المستخدم */
.Profile-card h2 {
    margin: 10px 0;
    color: #895159;
    font-size: 24px;
    display: flex;
    justify-content: center;
}

/* إحصائيات المهام */
.Profile-card p {
    font-size: 18px;
    margin: 5px 0;
    color: #374375;
    font-weight: 600;
    display: flex;
    justify-content: center;
    gap: 10px;
}

/* أزرار البطاقة */
.Profile-card button {
    border: none;
    color: #fffcf5;
    border-radius: 50px;
    padding: 10px;
    width: 150px;
    font-weight: 600;
    border: 2px #895159 solid;
    background-color: #dfaea1;
    margin: 8px 0;
    cursor: pointer;
}

.Profile-card button:hover {
    background-color: #895159;
    transition: 0.3s;
    color: white;
    border: 2px #dfaea1 solid;
}

</style>
</head>

<body>

<nav>
<ul>
<li><a href="wellcom.php" class="navBtn">الترحيب</a></li>
<li><a href="addTask.php" class="navBtn">المهام</a></li>
<li><a href="profile.php"class="navBtn">الملف الشخصي</a></li>
</ul>
</nav>

<div class="Profile-card">
    <div class="avatar"><?= strtoupper($user["username"][0]) ?></div>
    <h2>مرحبا <?= htmlspecialchars($user["username"]) ?></h2>

    <p>المنتظرة: <b><?= $stats["pending"] ?? 0 ?></b></p>

    <button onclick="location.href='addTask.php'">قائمة المهام</button>

    <!-- زر تسجيل الخروج بنفس الصفحة -->
    <form method="post" style="margin-top: 10px;">
        <button type="submit" name="logout">تسجيل الخروج</button>
    </form>
</div>

</body>
</html>
