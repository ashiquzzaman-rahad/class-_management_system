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
    <link rel="stylesheet" href="upload.css">
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
        <a href="">Study materials</a>
        <a href="assesment.php">Assesments</a>
        <a href="#">Help</a>
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
            if ($var == 'student') {
                echo "Name: " . $_SESSION['user_name'] . "<br>";
                echo "Student ID: " . $_SESSION['user_id'] . "<br>";
                echo "Discipline: " . $_SESSION['discipline_name'];

            } else if ($var == 'teacher') {
                echo "Name: " . $_SESSION['user_name'] . "<br>";
                echo "Teacher ID: " . $_SESSION['user_id'] . "<br>";
                echo "Designation: " . $_SESSION['designation'] . "<br>";
                echo "Discipline: " . $_SESSION['discipline_name'];
            }
            ?>
        </h3>
    </div>

    <?php
    require_once "config.php";
    $var = $_SESSION['role'];
    if ($var == 'student') {
        $stmt = $conn->prepare("SELECT * FROM takes NATURAL JOIN course where user_id = ?");
        $stmt->bind_param("s", $_SESSION['user_id']);
        $stmt->execute();
        $result4 = $stmt->get_result();

    } else if ($var == 'teacher') {
        $stmt = $conn->prepare("SELECT * FROM teaches NATURAL JOIN course where user_id = ?");
        $stmt->bind_param("s", $_SESSION['user_id']);
        $stmt->execute();
        $result4 = $stmt->get_result();
        ?>
            <div id="upload">
                <h2>Upload materials</h2>
                <form action="study_upload.php" method="POST">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" required><br><br>
                    <label for="link">link</label>
                    <input type="url" name="link" id="link" required><br><br>
                    <label for="course">Course</label>
                    <select name="course" id="course">
                        <?php
                        while ($row4 = $result4->fetch_assoc()) {
                            ?>
                            <option value=<?php echo $row4["course_id"] ?>>
                                <p><?php echo $row4["course_name"] ?></p>
                            </option>
                        <?php
                        }
                        ?>
                    </select><br><br>
                    <button type="submit">Upload</button><br><br>
                </form>
            </div>
        <?php
        $stmt = $conn->prepare("SELECT * FROM teaches NATURAL JOIN course where user_id = ?");
        $stmt->bind_param("s", $_SESSION['user_id']);
        $stmt->execute();
        $result4 = $stmt->get_result();
    }
    ?>
    <div id="upload">
    <h2>Search materials</h2>
        <form action="study_search.php" method="POST">
            <label for="course">Course</label>
            <select name="course" id="course">
                <?php
                while ($row4 = $result4->fetch_assoc()) {
                    ?>
                    <option value=<?php echo $row4["course_id"] ?>>
                        <p><?php echo $row4["course_name"] ?></p>
                    </option>
                    <?php
                }
                ?>
            </select><br><br>
            <button type="submit">Search</button><br><br>
        </form>
    </div>




    <script src="clock.js"></script>
    <script src="menu.js"></script>
</body>