<?php
session_start();
$login = false;

// check whether the session has the saved user_id or not
// if user log in
// get the user info
if (!empty($_SESSION['user_id'])) {
    $login = true;
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

    // select personalization from the Preference table
    $query = "SELECT * FROM Preference WHERE user_id ='$user_id'";
    $result = mysqli_query($connection, $query);
    $array = mysqli_fetch_assoc($result);

    //close the connection
    mysqli_close($connection);
} else {
    $login = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="assets/icons/favicon.png"/>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/publicNavigationBar.css">
    <link rel="stylesheet" href="css/forExplore.css">
</head>

<body>

<header>

    <nav>
        <div class="grid">

            <!-- search bar -->
            <div class="grid-col-1of3">
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <!-- filter -->
            <!-- filter section include one radio button and two selection inputs-->
            <div class="grid-col-1of3" id="filterCol">

                <!-- filter the page by submitting the page to itself with the right URI-->
                <form action="explore.php" method="get">

                    <!-- radio button -->
                    <?php
                    // get the hotness var through URI
                    // if it is empty meaning the hotness filter has not be applied yet
                    @$hotness = $_GET["hotness"];
                    if (!empty($hotness)) {
                        // if hotness var exists, echo the selected radio button and unselected radio buttons
                        // else just echo these two radio buttons
                        if ($hotness === "Hot") {
                            // if hotness is equal to hot, select the hot one
                            // else select another one
                            echo "<input type=\"radio\" name=\"hotness\" value=\"Hot\" checked=\"checked\"> Hot";
                            echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
                        } else {
                            echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot";
                            echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\" checked=\"checked\"> Not Hot";
                        }
                    } else {
                        // if login is true, echo the saved preferences
                        if ($login) {
                            if ($array['Hot'] == "Hot" && !empty($array['Hot'])) {
                                echo "<input type=\"radio\" name=\"hotness\" value=\"Hot\" checked=\"checked\"> Hot";
                                echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
                            } else {
                                echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot";
                                echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\" checked=\"checked\"> Not Hot";
                            }
                        } else {
                            echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot";
                            echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
                        }
                    }
                    ?>

                    <!-- select input filter section for department -->
                    <select name="department">
                        <!-- learnt how to add placeholder for select input from
                        https://stackoverflow.com/questions/5805059/how-do-i-make-a-placeholder-for-a-select-box-->
                        <option value="" disabled selected>Select The Department</option>

                        <!-- use php to find all the department -->
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

                        // write distinct select query
                        $query = "SELECT DISTINCT Department FROM Professor ORDER BY Department ASC";

                        // get the return data
                        $result = mysqli_query($connection, $query);

                        // print all the department from the array
                        @$department = $_GET["department"];

                        if(!empty($array['Department'])) {
                            echo "<option value=\"" . htmlspecialchars($array['Department']) . "\"" . "selected" . ">" .
                                htmlspecialchars($array['Department']) .
                                "</option>";
                        }

                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                // if there is a non-empty department value from URI
                                // echo a selected input
                                // else echo a regular input
                                if (!empty($department) && $row['Department'] === $department) {
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

                    <!-- select input filter section for school -->
                    <select name="school">
                        <option value="" disabled selected>Select The College</option>

                        <!-- use php to find all the school name from the data set by using the same method I used on the above
                        for finding all the departments -->
                        <?php

                        @$school = $_GET["school"];

                        // write distinct select query, order by ascending order
                        $query = "SELECT DISTINCT College FROM Professor ORDER BY College ASC";

                        // get the return data
                        $result = mysqli_query($connection, $query);

                        if(!empty($array['College'])) {
                            echo "<option value=\"" . htmlspecialchars($$array['School']) . "\"" . "selected" . ">" .
                                htmlspecialchars($array['College']) .
                                "</option>";
                        }

                        // fetch the data
                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                if (!empty($school) && $row["College"] === $school) {
                                    echo "<option value=\"" . htmlspecialchars($row["College"]) . "\"" . "selected" . ">" .
                                        htmlspecialchars($row["College"]) .
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

                    <input type="submit" name="filterSubmit" value="Filter">

                    <!-- clean the filter result by simply redirect to explore.php, the previous URI was removed -->
                    <a href="explore.php" id="filterCleanButton">Restart</a>
                </form>

            </div>

            <!-- login and sign up -->
            <div class="grid-col-1of3">
                <?php
                if ($login) {
                    echo "<ul id='loginMenu'>";
                    echo "<li><a href=\"index.php\">Log Out</a></li>";
                    echo "<li><a href=\"private/personalize.php\">Personalization</a></li>";
                    echo "<li><a href=\"private/settings.php\">Settings</a></li>";
                    echo "<li><a href=>welcome back, " . $username . "</a></li>";
                    echo "</ul>";
                } else {
                    echo "<button id=\"sideLoginButton\" onclick=\"location.href='login.php'\">Log in</button>
                          <button id=\"sideSignUpButton\" onclick=\"location.href='index.php'\">Sign Up</button>";
                }
                ?>

            </div>

        </div>
    </nav>

</header>

<script>
</script>


<div class="grid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3" id="containerOfList">
        <?php

        // get the filter form's fields values through GET
        // filter form -> hotness, department, school, filterSubmit
        @$hotness = $_GET["hotness"];
        @$department = $_GET["department"];
        @$school = $_GET["school"];
        @$filterSubmit = $_GET["filterSubmit"];

        // perform query
        // if filter from is submitted, append all the criteria to the query
        // else select all professor from the Professor table
        if (!empty($filterSubmit) && (!empty($hotness) || !empty($department) || !empty($school))) {
            if (!empty($hotness) && empty($department) && empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.Hot = '$hotness'";
            } else if (empty($hotness) && !empty($department) && empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.Department = '$department'";
            } else if (empty($hotness) && empty($department) && !empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.College = '$school'";
            } else if (!empty($hotness) && !empty($department) && empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.Hot = '$hotness' AND Professor.Department = '$department'";
            } else if (!empty($hotness) && empty($department) && !empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.Hot = '$hotness' AND Professor.College = '$school'";
            } else if (empty($hotness) && !empty($department) && !empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.College = '$school' AND Professor.Department = '$department'";
            } else if (!empty($hotness) && !empty($department) && !empty($school)) {
                $query = "SELECT * FROM Professor WHERE Professor.Hot = '$hotness' AND Professor.Department = '$department' AND Professor.College = '$school'";
            }
        } else {
            $query = "SELECT * FROM Professor";
        }

        $result = mysqli_query($connection, $query);

        // if query failed meaning there is no data meet the selection, create a bool for this statue
        $queryFailed = false;

        // if no rows are selected, query failed, print the error message
        if (mysqli_num_rows($result) == 0) {
            // if selection failed, leave the message
            $queryFailed = true;
        } else {
            $queryFailed = false;
        }

        // print the table
        echo "<table id=\"example\"";

        // print the table head
        echo "<tr><td>ID</td><td>Name</td><td>Overall Quality</td><td>Total Ratings</td><td>Hot</td><td>Easiness</td><td>Department</td><td>College</td></tr>";

        // if query failed, no selections meet the criteria, print the message
        if ($queryFailed) {
            echo "<tr><td colspan=\"8\">No available data for your selection, please modify your filter criteria.</td></tr>";
        }

        // fetch the assoc array
        while ($row = mysqli_fetch_assoc($result)) {
            $index = 0;
            echo "<tr>";

            // print each value
            foreach ($row as $value) {
                if ($index == 0) {
                    echo "<td><a href='theOne.php?Professor_id="
                        . urlencode(stripcslashes($value))
                        . "'>"
                        . stripcslashes($value)
                        . "</a></td>";
                } else {
                    echo "<td>"
                        . stripcslashes($value)
                        . "</td>";
                }
                $index++;
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