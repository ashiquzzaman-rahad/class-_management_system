<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "classroom_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_POST["username"];
$password = $_POST["PASSWORD"];
$signup_as = $_POST["signup_as"];


$sql = "SELECT * FROM user_info WHERE username = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt,"s", $username);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "The user already exists";
}
else{
    $sql = "INSERT INTO user_info (username, PASSWORD, signup_as) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $signup_as);

    if (mysqli_stmt_execute($stmt)) {
        if($signup_as == "Student")
        {
            echo "Welcome!";
            header("Location: welcome_student.html");
        }
        else if($signup_as == "Teacher")
        {
            echo "Welcome!";
            header("Location: welcome_teacher.html");
        }
        else if($signup_as == "Resourse Manager")
        {
            header("Location: welcome_resourse_man.html");
        }
        else
        {
            header("Location: welcome_discipline_admin.html");
        }
        
    } else {
        echo "Error!. mysqli_stmt_error($stmt)";
    }
}

mysqli_stmt_close($stmt);
$conn->close();
?>