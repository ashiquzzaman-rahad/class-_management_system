<?php
session_start();
$servername = "localhost";
$email = "root";
$password = "";
$dbname = "classroom_management_system";

$conn = new mysqli($servername, $email, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed!" . $conn->connect_error);
}

$user_email = $_POST["email"];
$user_password = $_POST["PASSWORD"];


$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND PASSWORD = ?");
$stmt->bind_param("ss", $user_email, $user_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM student WHERE email = ? AND PASSWORD = ?");
    $stmt->bind_param("ss", $user_email, $user_password);
    $stmt->execute();
    $result1 = $stmt->get_result();


    $stmt = $conn->prepare("SELECT * FROM teacher WHERE email = ? AND PASSWORD = ?");
    $stmt->bind_param("ss", $user_email, $user_password);
    $stmt->execute();
    $result2 = $stmt->get_result();

    $row1 = $result1->fetch_assoc(); 
    
    $row2 = $result2->fetch_assoc();
    
    


    if ($row1 > 0 && $row2 == 0) {
        $_SESSION['user_name'] = $row1["name"];
        $_SESSION['user_id'] = $row1['user_id'];
        $_SESSION['role'] = 'student';

        $stmt = $conn->prepare("SELECT discipline.name FROM student_from NATURAL JOIN discipline WHERE user_id = ?");
        $stmt->bind_param("s", $_SESSION['user_id']);
        $stmt->execute();
        $result3 = $stmt->get_result();
        $row3 = $result3->fetch_assoc();
        $_SESSION['discipline_name'] = $row3['name'];

        // $stmt = $conn->prepare("SELECT course_id, course_name, type, credit FROM takes NATURAL JOIN course where user_id = ?");
        // $stmt->bind_param("s", $_SESSION['user_id']);
        // $stmt->execute();
        // $result4 = $stmt->get_result();
        // $row4 = $result4->fetch_assoc();
        // $_SESSION['course_name'] = $row4['course_name'];

        header("Location:welcome.php");
    } else if ($row1 == 0 && $row2 > 0) {
        $_SESSION['user_name'] = $row2["name"]; 
        $_SESSION['user_id'] = $row2['user_id'];
        $_SESSION['designation'] = $row2["designation"];
        $_SESSION['role'] = 'teacher';
        $stmt = $conn->prepare("SELECT discipline.name FROM teacher_from NATURAL JOIN discipline WHERE user_id = ?");
        $stmt->bind_param("s", $_SESSION['user_id']);
        $stmt->execute();
        $result3 = $stmt->get_result();
        $row3 = $result3->fetch_assoc();
        $_SESSION['discipline_name'] = $row3['name'];
        header("Location:welcome.php"); 
    }

} 
else 
{
    echo "Invalid user";
}
$stmt->close();
$conn->close();