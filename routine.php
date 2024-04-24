<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="student.css">
    <link rel="stylesheet" href="coursetable.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <div id="mySidebar" class="sidebar">
        <button class="closebtn" onclick="closeNav()">×</button>
        <a href="welcome.php">Home</a>
        <a href="courses.php">Courses</a>
        <a href="">Routine</a>
        <a href="study_mat.php">Study materials</a>
        <a href="assesment.php">Assesments</a>
        <a href="#">Help</a>
        <!-- <button>Log out</button> -->
    </div>
    <div id="main">
        <button class="openbtn" onclick="openNav()">☰ Menu</button>
        <h1>Class Management System</h1> <br>
        <div id="clock"></div>
        <div id="date"></div>
        <div id="day"></div>
    </div>

    <div id="identity">
        <h3>
        <?php
            $var = $_SESSION['role'];
            if($var == 'student')
            {
                echo "Name: ". $_SESSION['user_name']."<br>";
                echo "Student ID: " . $_SESSION['user_id']."<br>";
                echo "Discipline: " . $_SESSION['discipline_name'];

            }
            else if($var == 'teacher')
            {
                echo "Name: ". $_SESSION['user_name']."<br>";
                echo "Teacher ID: " . $_SESSION['user_id']."<br>";
                echo "Designation: " . $_SESSION['designation']."<br>";
                echo "Discipline: " . $_SESSION['discipline_name'];
            }
            ?>
        </h3>
    </div>

    <?php
        date_default_timezone_set("Asia/Dhaka");
        $currentDate = new DateTime();
        $today = new DateTime();
        $time = $today->format('H');
        if($time >= 20)
        {
            $currentDate->modify('+1 day');
        }
        $date = $currentDate->format('Y-m-d');
        $day = $currentDate->format('l');
        
        if($day == "Friday" || $day == "Saturday")
        {
    ?>

    <div class="marquee-container">
        <h2 class="marquee-text">NO CLASS TOMORROW... CHECK AFTER 8 PM FOR UPDATE...</h2>
    </div>

    <?php
        }
        else
        {
    ?>
    <?php
        require_once "config.php";
        $var = $_SESSION['role'];
        if($var == 'student')
        {
            $stmt = $conn->prepare("SELECT start_time, end_time, take_rou.course_id, course.course_name 
            FROM takes NATURAL JOIN routine as take_rou NATURAL JOIN course
            where user_id = ? and day = ?");
            $stmt->bind_param("ss", $_SESSION["user_id"], $day);
            $stmt->execute();
            $result4 = $stmt->get_result();
        }
        else if($var == 'teacher')
        {
            $stmt = $conn->prepare("SELECT start_time, end_time, take_rou.course_id, course.course_name 
            FROM teaches NATURAL JOIN routine as take_rou NATURAL JOIN course
            where user_id = ? and day = ?");
            $stmt->bind_param("ss", $_SESSION['user_id'],$day);
            $stmt->execute();
            $result4 = $stmt->get_result();
        }
        if ($result4->num_rows == 0){
    ?>

    <div class="marquee-container">
        <h2 class="marquee-text">NO CLASS TOMORROW... CHECK AFTER 8 PM FOR UPDATE...</h2>
    </div>

    <?php
        }
        else
        {
    ?>

    <div id="course">
        <table style="width: 100%";>
            <caption>Routine of:</caption>
            <caption><?php echo "Date: ". $date ?></caption>
            <caption><?php echo $day ?></caption>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>Course ID</th>
                <th>Course name</th>
            </tr>
            <tr>
                <?php
                    while($row4 = $result4->fetch_assoc()){
                ?>
                <td><?php echo $row4["start_time"]?></td>
                <td><?php echo $row4["end_time"]?></td>
                <td><?php echo $row4["course_id"]?></td>
                <td><?php echo $row4["course_name"]?></td>    
            </tr>
                <?php
                    }  
                ?>
        
        </table>
    </div>
    <?php
        }
        }
    ?>

    <script src="clock.js"></script>
    <script src="menu.js"></script>
</body>
</html>