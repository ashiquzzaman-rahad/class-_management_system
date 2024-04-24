<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="student.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
</head>
<body>
<div id="mySidebar" class="sidebar">
        <button class="closebtn" onclick="closeNav()">×</button>
        <a href="welcome.php">Home</a>
        <a href="courses.php">Courses</a>
        <a href="routine.php">Routine</a>
        <a href="study_mat.php">Study materials</a>
        <a href="">Assesments</a>
        <a href="">Help</a>
        <!-- <button>Log out</button> -->
    </div>
    <div id="main">
        <button class="openbtn" onclick="openNav()">☰ Menu</button>
        <h1>Class Management System</h1> <br>
        <div id="clock"></div>
        <div id="date"></div>
        <div id="day"></div>
    </div>



    <script src="menu.js"></script>
    <script src="clock.js"></script>
</body>
</html>