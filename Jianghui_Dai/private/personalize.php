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
$user_id = $_SESSION['user_id'];

// select the query to show the previous saved info
$query = "SELECT * FROM Preference WHERE user_id ='$user_id'";
$result = mysqli_query($connection, $query);

// check select query return any rows
if (mysqli_num_rows($result) != 0) {
    $array = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
}

if (isset($school) && isset($department) && isset($hotness)) {
    // check if the user preference was inserted already
    $selectQuery = "SELECT * FROM Preference WHERE user_id = '$user_id'";
    $resultForSelect = mysqli_query($connection, $selectQuery);

    // check select query return any rows, if there are no rows selected meaning there is no data
    // so insert the data
    // otherwise, update the data
    if (mysqli_num_rows($resultForSelect) == 0) {
        $sql = "INSERT INTO Preference (user_id, College, Department, Hot) VALUES ('$user_id', '$school', '$department', '$hotness')";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            // if insert success, go to home page
            mysqli_free_result($result);
            mysqli_close($connection);
            header("Location:../explore.php");
        } else {
            // close the connection
            mysqli_close($connection);
            // if insert failed, leave the message
            die("Database query failed. " . mysqli_error($connection));
        }
    } else {
        // free returned result
        mysqli_free_result($resultForSelect);

        // write update query yo update user preference
        $sql = "UPDATE Preference SET College='$school', Department='$department', Hot='$hotness' WHERE user_id='$user_id'";

        // perform query
        $result = mysqli_query($connection, $sql);

        if ($result) {
            // if update success, go to home page
            mysqli_close($connection);
            header("Location:../explore.php");
        } else {
            // close the connection
            mysqli_close($connection);
            // if update failed, leave the message
            die("Database query failed. " . mysqli_error($connection));
        }
    }
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personalize | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="../assets/icons/favicon.png"/>
    <link rel="stylesheet" href="../css/grid.css">
    <link rel="stylesheet" href="../css/publicNavigationBar.css">
    <link rel="stylesheet" href="../css/forPersonalize.css">
</head>

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
                <li><a href="settings.php"">Settings</a></li>
                <li><a href="../explore.php"">Home</a></li>
            </ul>
        </div>

    </div>
</nav>

<body>

<div class="grid">
    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">

        <!-- personalize form-->
        <form method="post" action="personalize.php">
            <h2>what college are you in?</h2>
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
                        if (!empty($array['College']) && $row['College'] === $array['College']) {
                            echo "<option value=\"" . htmlspecialchars($$array['School']) . "\"" . "selected" . ">" .
                                htmlspecialchars($array['College']) .
                                "</option>";
                        } else {
                            echo "<option value=\"" . htmlspecialchars($row["College"]) . "\">" .
                                htmlspecialchars($row["College"]) .
                                "</option>";
                        }
                    }
                }

                // release returned data
                mysqli_free_result($result);

                ?>
            </select>

            <h2>which department are you in?</h2>
            <!-- Department -->
            <select name="department">
                <option value="" disabled selected>Select The Department</option>
                <?php
                // write distinct select query
                $query = "SELECT DISTINCT Department FROM Professor ORDER BY Department ASC";

                // get the return data
                $result = mysqli_query($connection, $query);


                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        if (!empty($array['Department']) && $row['Department'] === $array['Department']) {
                            echo "<option value=\"" . htmlspecialchars($row['Department']) . "\"" . "selected" . ">" .
                                htmlspecialchars($row['Department']) .
                                "</option>";
                        } else {
                            echo "<option value=\"" . htmlspecialchars($row['Department']) . "\">" .
                                htmlspecialchars($row['Department']) .
                                "</option>";
                        }
                    }
                }

                // release returned data
                mysqli_free_result($result);
                ?>
            </select>
            <br><br>

            <?php
            if (!empty($array['Hot'])) {
                if ($array['Hot'] == "Hot" && !empty($array['Hot'])) {
                    echo "<input type=\"radio\" name=\"hotness\" value=\"Hot\" checked=\"checked\"> Hot";
                    echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
                } else {
                    echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot";
                    echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\" checked=\"checked\"> Not Hot";
                }
            } else {
                echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot       ";
                echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
            }
            ?>
            <br><br>
            <input type="submit" value="submit">
        </form>
    </div>

    <div class="grid-col-1of3"></div>
</div>

</body>
</html>