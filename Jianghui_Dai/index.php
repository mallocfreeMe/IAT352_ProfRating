<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="assets/icons/favicon.png"/>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/publicNavigationBar.css">
    <link rel="stylesheet" href="css/forIndex.css">

    <!-- raw js to animate the form -->
    <script type="text/javascript">
        // learn how to show and hide form from https://www.w3schools.com/howto/howto_js_toggle_hide_show.asp
        function showForm() {
            let registrationForm = document.getElementById("registrationForm");
            let loginButton = document.getElementById("loginButton");
            let startButton = document.getElementById("startButton");
            let sideLoginButton = document.getElementById("sideLoginButton");
            let visitorLink = document.getElementById("visitor_link");

            if (registrationForm.style.display === "none") {
                registrationForm.style.display = "block";
                loginButton.style.display = "none";
                sideLoginButton.style.display = "block";
            }

            startButton.style.display = "none";
            visitorLink.style.display = "none";
        }

        // use onsubmit method to validate the form before submitted to the php
        // I learnt it from https://www.w3schools.com/jsref/event_onsubmit.asp
        function validate() {
            let email = document.getElementById("registrationFormEmail").value;
            let password = document.getElementById("registrationFormPassword").value;
            let username = document.getElementById("registrationFormUsername").value;
            if (password === "" || email === "" || username === "") {
                alert("You do have to fill this stuff out, you know.");
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<body>

<!-- Create JianghuiDai database -->
<?php

// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$connection = mysqli_connect($servername, $username, $password);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// if the JianghuiDai database is not exist, create this database
// learn how to check if it exists from https://stackoverflow.com/questions/838978/how-to-check-if-mysql-database-exists
$sql = "CREATE DATABASE IF NOT EXISTS JianghuiDai";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// Close database connection
mysqli_close($connection);

?>

<!-- Create Professor table and User table in JianghuiDai database-->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "JianghuiDai";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to create User table
$sqlForUser = "CREATE TABLE IF NOT EXISTS User (
                user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(30) NOT NULL,
                email VARCHAR(50))";

// sql to create Professor table
$sqlForProfessor = "CREATE TABLE IF NOT EXISTS Professor(
                    Professor_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    NAME VARCHAR(35) NOT NULL,
                    Overall_Quality NUMERIC(3, 1),
                    Total_Ratings INTEGER NOT NULL,
                    Hot VARCHAR(7) NOT NULL,
                    Easiness NUMERIC(3, 1),
                    Department VARCHAR(30) NOT NULL,
                    College VARCHAR(9) NOT NULL)";

$resultForUser = mysqli_query($connection, $sqlForUser);
$resultForProfessor = mysqli_query($connection, $sqlForProfessor);

if (!$resultForUser || !$resultForProfessor) {
    die("Database query failed.");
}

// open the insert sql file
$insertFile = fopen("assets/data/insertProfessor.sql", "r") or die("Unable to open file!");

// make a select query to verify whether data is inserted or not
$selectQuery = "SELECT * FROM Professor WHERE College = 'Duke'";
$resultForSelect = mysqli_query($connection, $selectQuery);

// check select query return any rows, if there are no rows selected meaning there is no data
// so insert the data
// otherwise, data was already inserted
if (mysqli_num_rows($resultForSelect) == 0) {
    while (!feof($insertFile)) {
        $insertQuery = fgets($insertFile);
        $resultForInsert = mysqli_query($connection, $insertQuery);
        if (!$resultForInsert) {
            fclose($insertFile);
            die("Database query failed. " . mysqli_error($connection));
        }
    }
}

// close the insert sql file
fclose($insertFile);

// close the connection
mysqli_close($connection);

?>

<!-- nav -->
<header>

    <nav>
        <div class="grid">

            <!-- search bar with its icon -->
            <div class="grid-col-1of3">
                <a href="explore.php">
                    <img src="assets/icons/professor.png" class="searchIcon">
                </a>
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">

                <!-- nav log in button-->
                <button id="sideLoginButton" style="display: none" onclick="location.href='login.php'">Log in</button>

                <!-- nav sign up button-->
                <button id="sideSignUpButton" style="display: none" onclick="location.href='index.php'">Sign Up
                </button>
            </div>

        </div>
    </nav>

</header>

<!-- First page-->
<section class="firstPage">

    <div class="grid">

        <div class="grid-col-1of3"></div>

        <!-- main content -->
        <div class="grid-col-1of3" id="topPart">

            <!-- website name -->
            <h1 class="websiteName">ProfRating</h1>

            <!-- web slogan -->
            <p class="websiteSlogan">Join us, find the professor you are looking for.</p>
            <br>

            <!-- register button for new users -->
            <button id="startButton" onclick="showForm()">Get Started</button>
            <br>

            <!-- registration form -->
            <form action="processRegister.php" method="post" id="registrationForm" style="display: none"
                  onsubmit="return validate();">

                <input type="email" name="email" placeholder="Email" id="registrationFormEmail">
                <br>

                <input type="password" name="password" placeholder="Password" id="registrationFormPassword">
                <br>

                <input type="text" name="username" placeholder="Username" id="registrationFormUsername">
                <br>

                <input id="sign_up_button" type="submit" name="submit" value="Sign up">
                <br>
            </form>

            <!-- login button for registered users -->
            <button onclick="location.href='login.php'" id="loginButton">Log In</button>
            <br>

            <!-- a link for visitors to visit -->
            <a href="explore.php" class="visitorLink" id="visitor_link">
                <img src="assets/icons/compass.png" id="visitorLinkIcon">Here's Prof List
            </a>

        </div>

        <div class="grid-col-1of3"></div>

    </div>

</section>

<!-- footer -->
<!-- An internal link to the second page -->
<footer class="grid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">
        <a href="#definition">What is ProfRating?</a>
    </div>

    <div class="grid-col-1of3"></div>

</footer>

<!-- Second Page -->
<section class="secondPage" id="definition">
    <div class="grid"></div>
</section>


<!-- Third Page -->
<section class="thirdPage">
    <div class="grid"></div>
</section>

</body>

</html>