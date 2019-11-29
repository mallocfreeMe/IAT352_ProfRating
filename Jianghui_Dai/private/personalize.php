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

// get the data from POST
@$school = $_POST['school'];
@$department = $_POST['department'];
@$hotness = $_POST['hotness'];

// if the form was submitted
// insert data to Preference table
if (isset($school) && isset($department) && isset($hotness)) {
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO Preference (user_id, College, Department, Hot) VALUES ('$user_id', '$school', '$department', '$hotness')";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        // if insert success, go to home page
        mysqli_free_result($result);
        mysqli_close($connection);
        header("Location:home.php");
    } else {
        // close the connection
        mysqli_close($connection);
        // if insert failed, leave the message
        die("Database query failed. " . mysqli_error($connection));
    }
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personalize | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="../assets/icons/favicon.png"/>
    <link rel="stylesheet" href="css/grid.css">
</head>

<body>

<div class="grid">
    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">

        <!-- personalize form-->
        <form method="post" action="personalize.php">
            <h1>what college are you in?</h1>
            <!-- school -->
            <select name="school">
                <option value="" disabled selected>Select The College</option>

                <!-- use php to find all the school name from the data set by using the same method I used on the above
                for finding all the departments -->
                <?php

                // write distinct select query, order by ascending order
                $query = "SELECT DISTINCT College FROM Professor ORDER BY College ASC";

                // get the return data
                $result = mysqli_query($connection, $query);

                // fetch the data
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"" . htmlspecialchars($row["College"]) . "\">" .
                            htmlspecialchars($row["College"]) .
                            "</option>";
                    }
                }

                // release returned data
                mysqli_free_result($result);

                ?>
            </select>

            <h1>which department are you in?</h1>
            <!-- Department -->
            <select name="department">
                <?php
                // write distinct select query
                $query = "SELECT DISTINCT Department FROM Professor ORDER BY Department ASC";

                // get the return data
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"" . htmlspecialchars($row['Department']) . "\">" .
                            htmlspecialchars($row['Department']) .
                            "</option>";
                    }
                }

                // release returned data
                mysqli_free_result($result);
                ?>
            </select>

            <?php
            echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot";
            echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
            ?>

            <input type="submit" value="submit">
        </form>
    </div>

    <div class="grid-col-1of3"></div>
</div>

</body>
</html>