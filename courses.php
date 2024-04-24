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
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>
<body>
    <div id="mySidebar" class="sidebar">
        <button class="closebtn" onclick="closeNav()">×</button>
        <a href="welcome.php">Home</a>
        <a href="#">Courses</a>
        <a href="routine.php">Routine</a>
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
        require_once "config.php";
        $var = $_SESSION['role'];
        if($var == 'student')
        {
            $stmt = $conn->prepare("SELECT course_id, course_name,credit,type FROM takes NATURAL JOIN course where user_id = ?");
            $stmt->bind_param("s", $_SESSION['user_id']);
            $stmt->execute();
            $result4 = $stmt->get_result();

        }
        else if($var == 'teacher')
        {
            $stmt = $conn->prepare("SELECT course_id, course_name, credit, section FROM teaches NATURAL JOIN course where user_id = ?");
            $stmt->bind_param("s", $_SESSION['user_id']);
            $stmt->execute();
            $result4 = $stmt->get_result();
        }
    ?>


    <div id="course" >
        <table id="coursetable" style="width: 100%";>
            <caption>List of Courses</caption>
            <tr>
                <th>Course Id</th>
                <th>Course name</th>
                <th>Credit</th> 
                <?php
                    if($var == 'student')
                    {
                ?>
                <th>Type</th>
                <?php        
                    }
                    else if($var == 'teacher'){
                ?>
                <th>Section</th>
                <?php
                    }
                ?>
            </tr>
            <tr>
                <?php 
                    while($row4 = $result4->fetch_assoc()){
                ?>
                <td><?php echo $row4["course_id"]?></td>
                <td><a href="welcome.php"><?php echo $row4["course_name"]?></a></td>
                <td><?php echo $row4["credit"]?></td>
                <?php
                    if($var == 'student')
                    { 
                ?>  
                <td><?php echo $row4["type"]?></td>
                <?php
                    }
                    else if($var == 'teacher')
                    {
                ?>
                <td><?php echo $row4["section"]?></td>
                <?php        
                    }
                ?>
            </tr>
                <?php
                    }               
                ?>
           
        </table>
    </div>


    <script src="clock.js"></script>
    <script src="menu.js"></script>
</body>
</html>