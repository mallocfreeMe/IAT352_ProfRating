<html lang="en">

<?php

@$user_id = trim($_GET["user_id"]);

// if user_id is empty meaning user enter here without log in
// redirect user back to index.html
if (empty($user_id)) {
    header("Location: ../login.php");
    die();
}

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

// query to select user_id from the User table
$query = "SELECT User.username FROM User WHERE User.user_id ='$user_id'";

$result = mysqli_query($connection, $query);

$array = mysqli_fetch_assoc($result);

$username = $array['username'];

// free the returned data
mysqli_free_result($result);

// Close database connection
mysqli_close($connection);
?>

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
                    <?php
                    // encode user_id to url
                    $url = "settings.php?user_id=" . $user_id;
                    echo "<li><a href=\"". $url ."\">Settings</a></li>";

                    echo "<li><a href=>welcome back, " . $username . "</a></li>";
                    ?>
                </ul>
            </div>

        </div>
    </nav>

</header>


<div class="grid">
    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">

        <?php
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
