<?php
// start a session
session_start();

// check whether the session has the saved user_id or not
if (!empty($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
} else {
    // destroy the session
    session_destroy();
    // redirect to home page
    header("Location: ../index.php");
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

// query to select user_id from the User table, add all user info to arrat
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM User WHERE User.user_id ='$user_id'";

$result = mysqli_query($connection, $query);

if (!$result) {
    // if selection failed, leave the message
    mysqli_close($connection);
    header("Location: login.php");
    die("Database query failed. " . mysqli_error($connection));
}

$array = mysqli_fetch_assoc($result);
$username = $array['username'];

// free the returned data
mysqli_free_result($result);

// close the connection
mysqli_close($connection);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="../assets/icons/favicon.png"/>
    <link rel="stylesheet" href="../css/grid.css">
    <link rel="stylesheet" href="../css/publicNavigationBar.css">
    <link rel="stylesheet" href="../css/forSettings.css">
</head>

<body>

<nav>
    <div class="grid">

        <!-- search bar with its icon -->
        <div class="grid-col-1of3">
            <input type="text" placeholder="Search Prof" size="50" id="searchBar">
        </div>

        <div class="grid-col-1of3"></div>

        <div class="grid-col-1of3">
            <ul style="color: white">
                <li><a href="../index.php">Log Out</a></li>
                <li><a href="personalize.php"">Personalization</a></li>
                <li><a href="../explore.php"">Home</a></li>
                <?php echo "<li><a href=>welcome back, " . $username . "</a></li>"; ?>
            </ul>
        </div>

    </div>
</nav>

<div class="grid">
    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3" id="content">
        <h2>User Info</h2>
        <?php
        echo "<table>";
        echo "<tr><td>name</td><td>email</td><td>password</td></tr>";
        echo "<tr><td>" . $array['username'] . "</td>";
        echo "<td>" . $array['email'] . "</td>";
        echo "<td>" . $array['password'] . "</td></tr>";
        echo "</table>";
        ?>

        <!-- Change your password-->
        <h2>Change your password</h2>

        <form action="settings.php" method="post">
            New Password: <input type="text" name="newPassword">
            <input type="submit" value="submit">
        </form>

        <?php
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

        // update the password
        @$newPassword = trim($_POST['newPassword']);

        if (!empty($newPassword)) {
            $sql = "UPDATE user SET password = '$newPassword' WHERE user_id = '$user_id'";

            $result = mysqli_query($connection, $sql);

            if (!$result) {
                // if query failed, leave the message
                mysqli_close($connection);
                die("Database query failed. " . mysqli_error($connection));
            }

            // if query failed, leave the message
            mysqli_close($connection);
        }

        ?>

    </div>

    <div class="grid-col-1of3"></div>
</div>

</body>
</html>