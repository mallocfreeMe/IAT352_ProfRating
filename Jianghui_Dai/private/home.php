<?php
// start a session
session_start();

// check whether the session has the saved user_id or not
// if it's not
if (empty($_SESSION['user_id'])) {
    // destroy the session
    session_destroy();
    // redirect to home page
    header("Location: ../index.php");
    die();
}

// Create a database connection
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Jianghui_Dai";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Test if connection succeeded
if (mysqli_connect_errno()) {
    // if connection failed, skip the rest of PHP code, and print an error
    die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")"
    );
}

// query to select user_id (from session) from the User table
$user_id = $_SESSION['user_id'];
$query = "SELECT User.username FROM User WHERE User.user_id ='$user_id'";
$result = mysqli_query($connection, $query);
$array = mysqli_fetch_assoc($result);
$username = $array['username'];
// free the returned data
mysqli_free_result($result);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="../assets/icons/favicon.png"/>
    <link rel="stylesheet" href="../css/grid.css">
    <link rel="stylesheet" href="../css/publicNavigationBar.css">
    <link rel="stylesheet" href="../css/forHome.css">
</head>

<body>

<!-- nav -->
<header>

    <nav>
        <div class="grid">

            <!-- search bar with its icon -->
            <div class="grid-col-1of3">
                <img src="../assets/icons/professor.png" class="searchIcon">
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">
                <ul>
                    <li><a href="../index.php">Log Out</a></li>
                    <li><a href=\"". $url ."\">Settings</a></li>
                    <?php echo "<li><a href=>welcome back, " . $username . "</a></li>"; ?>
                </ul>
            </div>

        </div>
    </nav>

</header>


<div class="grid">
    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">

        <?php
        $query = "SELECT * FROM Professor WHERE College='UChicago'";

        $result = mysqli_query($connection, $query);

        // print the table
        echo "<table>";

        // print the table head
        echo "<tr><td>ID</td><td>Name</td><td>Overall Quality</td><td>Total Ratings</td><td>Hot</td><td>Easiness</td><td>Department</td><td>College</td></tr>";

        // fetch the assoc array
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // print each value
            foreach ($row as $value) {
                echo "<td>"
                    . stripcslashes($value)
                    . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // release returned data
        mysqli_free_result($result);

        // close the connection
        mysqli_close($connection);
        ?>

    </div>

    <div class="grid-col-1of3"></div>
</div>

</body>
</html>
