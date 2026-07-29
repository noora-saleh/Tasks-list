<?php
session_start();
if(!isset($_SESSION["userid"])){
    header("location:createacc.php");
    exit;
}

$conn = new mysqli("localhost","root","","todoo");

// Handle adding new task
if(isset($_POST["add"])){
    $task = $_POST["taskInput"];
    $date = $_POST["taskDate"];

    $today = strtotime(date("Y-m-d"));
    $entered = strtotime($date);

    if($entered >= $today){
        $check = $conn->prepare("SELECT id FROM task WHERE taskName=? AND taskDate=? AND user_id=?");
        $check->bind_param("ssi", $task, $date, $_SESSION["userid"]);
        $check->execute();
        $res = $check->get_result();

        if($res->num_rows == 0){
            $insert = $conn->prepare("INSERT INTO task (taskName, taskDate, user_id)VALUES (?, ?, ?)");
            $insert->bind_param("ssi", $task, $date, $_SESSION["userid"]);
            $insert->execute();
        }
    } 
    else {
        echo "<script>alert('لا يمكنك اختيار تاريخ مضى بالفعل!');</script>";
    }
}

// Handle display request
$tasks = [];
if(isset($_POST["display"])){
    $query = $conn->prepare("SELECT * FROM task WHERE user_id = ? ORDER BY id ASC");
    $query->bind_param("i", $_SESSION["userid"]);
    $query->execute();
    $result = $query->get_result();

    while($row = $result->fetch_assoc()){
        // Only add tasks that haven't been shown yet
            $tasks[] = $row;
        }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add task</title>
    <style>
        body {
            margin: 0;
            background-color: #fffcf5;
        }

        div:last-child a {
            text-decoration: underline;
            font-weight: 600;
        }

        /* نافبار */
        nav {
            background-color: #374375;
            padding: 10px;
            font-size: 20px;
        }

        ul {
            margin-top: 0;
            list-style: none;
            display: flex;
            gap: 10px;
            direction: rtl;
            margin-top: 10px;
            justify-content: space-around;
        }

        a {
            text-decoration: none;
            color: #E4D8C8;
        }

        /* زر تسجيل الدخول */
        .cta {
            border: none;
            border-radius: 50px;
            padding: 10px;
            width: 90px;
            font-weight: 600;
            background-color: #374375;
            color: #fffcf5;
            font-weight: 600;
        }

        .cta:hover {
            transition: 0.3s;
            background-color: #babde2;
            color: white;
        }

        /* بقية الازرار */
        .navBtn {
            border: none;
            border-radius: 50px;
            padding: 10px;
            width: 90px;
            font-weight: 600;
            font-weight: 600;
            background-color: #babde2;
            color: white;
        }

        .navBtn:hover {
            transition: 0.3s;
            background-color: #374375;
            color: #fffcf5;
        }

        /* الحاوية الاساسية */
        .container {
            display: flex;
            flex-direction: column;
            justify-self: center;
            margin: 50px;
            width: 500px;
            background-color: #babde2;
            padding: 15px;
            border-radius: 50px;
            min-height: 130px;
            height: auto;

            justify-items: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }

        /* مسافات حقول الادخال */
        .inp {
        display: flex;
        flex-direction: column; /* stack inputs vertically */
        gap: 15px;              /* space between inputs */
        margin-top: 30px;
        }

        .inp,
        .btn,
        p {
            display: flex;
            margin-bottom: 10px;
            justify-content: center;
            gap: 10px;
        }

        /* ازرار الحاوية الاساسية */
        button {
            border: none;
            color:#fffcf5;
            border-radius: 50px;
            padding: 10px;
            width: 90px;
            font-weight: 600;
            border:2px #895159 solid;
            background-color: #dfaea1;
        }

        button:hover {
            background-color: #895159;
            transition: 0.3s;
            color: white;
            border:2px #dfaea1 solid;
        }

        /* تنسيق المدخلات */
        input {
            border-radius: 50px;
            border: 2px #374375 solid;
            padding: 10px;
            background-color: #fffcf5;
        }

        /* العنوان الرئيسي */
        h1 {
            color: #895159;
            display: flex;
            justify-content: center;
        }

        #add {
            color:#fffcf5;
        }
       .taskBox {
            background-color: #fffcf5;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 10px;
            border: 2px #374375 solid;
        }

        .taskLabel input[type="checkbox"]{
            gap: 10px;
            cursor: pointer;
        }

        .taskLabel input[type="checkbox"]:checked + .taskText {
            color: #a37b7bff;
        }

    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="zuhair-2.php" class="cta"> تسجيل الدخول</a> </li>
            <li><a href="wellcom.php" class="navBtn">الترحيب</a></li>
            <li><a href="addTask.php" class="navBtn">المهام</a></li>
            <li><a href="profile.php" class="navBtn"> الملف الشخصي</a> </li>
        </ul>
    </nav>
    <!-- onsubmit="return validateDate()" -->
    <h1>اضف مهامك</h1>
    <form action="" method="post" >
        <div class="container">
            <div class="inp">
                <input type="text" id="taskInput" name="taskInput" placeholder="اضافة المهام">
                <input type="date" id="taskDate" name="taskDate">
            </div>
            <div class="btn">
                <button type="submit"id="add" name="add">اضافة</button>
            </div>
        </div>
    </form>
<h1>المهام المضافة</h1>

<div class="container">
    <?php if(!empty($tasks)): ?>
        <?php foreach($tasks as $taskItem): ?>
<div class="taskBox">
    <label class="taskLabel">
        <input type="checkbox" >
            <span class="taskText">
            <?php echo "<b>Task:</b>". $taskItem["taskName"]; ?>
            <?php echo "/<b>Date: </b>".$taskItem["taskDate"]; ?>
            </span>
    </label>
</div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>لا توجد مهام حالياً</p>
    <?php endif; ?>

    <form action="" method="post">
        <div class="btn display">
            <button type="submit" name="display">عرض</button>
        </div>
    </form>
</div>

<!-- <script>
function validateDate() {
    const dateInput = document.getElementById('taskDate').value;
    const today = new Date();
    today.setHours(0,0,0,0); // ignore time
    const selectedDate = new Date(dateInput);

    if(selectedDate < today){
        alert('لا يمكنك اختيار تاريخ مضى بالفعل!');
        return false; // prevent form submission
    }
    return true;
} -->
</script>

</body>
</html>