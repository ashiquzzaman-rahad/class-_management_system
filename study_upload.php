<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "classroom_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$title = $_POST["title"];
$link = $_POST["link"];
$course = $_POST["course"];

$sql = "INSERT INTO study_mat (title, link, course_id) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "sss", $title, $link, $course);

if (mysqli_stmt_execute($stmt)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="student.css">
        <link rel="stylesheet" href="materialtable.css">
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
        <?php
        $course = $_POST["course"];

        $stmt = $conn->prepare("SELECT * FROM study_mat where course_id = ?");
        $stmt->bind_param("s", $course);
        $stmt->execute();
        $result4 = $stmt->get_result();
        ?>
        <div id="material">
            <table style="width: 100%" ;>
                <caption>Study materials: <?php echo $course ?></caption>
                <tr>
                    <th>Title</th>
                    <th>Link</th>
                </tr>
                <tr>
                    <?php
                    while ($row4 = $result4->fetch_assoc()) {
                        ?>
                        <td><?php echo $row4["title"] ?></td>
                        <td><a href=<?php echo $row4["link"] ?> target="_blank">Link</a></td>
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

    <?php
} else {
    echo "Error!. mysqli_stmt_error($stmt)";
}

mysqli_stmt_close($stmt);
$conn->close();
?>