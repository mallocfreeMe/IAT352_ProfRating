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
                <img src="assets/icons/professor.png" class="searchIcon">
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
                        echo " <input type=\"radio\" name=\"hotness\" value=\"Hot\"> Hot";
                        echo "<input type=\"radio\" name=\"hotness\" value=\"Not Hot\"> Not Hot";
                    }
                    ?>

                    <!-- select input filter section for department -->
                    <select name="department">
                        <!-- learnt how to add placeholder for select input from
                        https://stackoverflow.com/questions/5805059/how-do-i-make-a-placeholder-for-a-select-box-->
                        <option value="" disabled selected>Select The Department</option>

                        <!-- use php to find all the department -->
                        <?php
                        // learn how to load csv file in php from
                        // https://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
                        $handler = fopen("assets/data/ratemyprofessors.csv", "r");

                        // created a var to avoid print first line of data set
                        $countForFirstLine = 0;

                        // created an array for avoiding repeating the same string
                        $noRepeatWordArray = array("test");

                        // use fgetcsv() function to parse the csv file
                        while (($line = fgetcsv($handler)) !== false) {
                            // count is a moving pointer I use
                            $count = 0;

                            // length: 6 cells
                            foreach ($line as $cell) {
                                // when count equals to 5, it reaches department column. Print the cell, count move one cell forward
                                // when count equals to 6, it reaches the end of the column, set to 0, ready for next row
                                // otherwise count++ to iterate through the column
                                if ($count == 5 && $countForFirstLine == 1) {

                                    // create a bool as state checker
                                    $repeat = false;

                                    foreach ($noRepeatWordArray as $word) {
                                        // use strcmp to comparing the $word and every $cell from the array
                                        // it returns 0 means two string are equal
                                        // set $repeat to true
                                        // break the loop
                                        // learnt from https://www.geeksforgeeks.org/php-strcmp-function/
                                        $filterResult = strcmp($word, htmlspecialchars($cell));
                                        if ($filterResult == 0) {
                                            $repeat = true;
                                            break;
                                        }
                                    }

                                    // if the word is not repeated from the array
                                    // use array_push to add the words to the array
                                    if ($repeat == false) {
                                        array_push($noRepeatWordArray, htmlspecialchars($cell));
                                    }

                                    $count++;
                                } else if ($count == 6) {
                                    $count = 0;
                                } else {
                                    $count++;
                                }
                            }

                            // var to print first line of the data set
                            if ($countForFirstLine == 0) {
                                $countForFirstLine++;
                            }
                        }
                        fclose($handler);

                        // remove 'test' word I added in the beginning when I created the $noRepeatWordArray
                        if (($key = array_search('test', $noRepeatWordArray)) !== false) {
                            unset($noRepeatWordArray[$key]);
                        }

                        // use asort to sort the array alphabetically
                        asort($noRepeatWordArray);

                        // print all the department from the array
                        @$department = $_GET["department"];
                        foreach ($noRepeatWordArray as $cell) {
                            // if there is a non-empty department value from URI
                            // echo a selected input
                            // else echo a regular input
                            if (!empty($department) && $cell === $department) {
                                echo "<option value=\"" . htmlspecialchars($cell) . "\"" . "selected" . ">" .
                                    htmlspecialchars($cell) .
                                    "</option>";
                            } else {
                                echo "<option value=\"" . htmlspecialchars($cell) . "\">" .
                                    htmlspecialchars($cell) .
                                    "</option>";
                            }
                        }
                        ?>

                    </select>

                    <!-- select input filter section for school -->
                    <select name="school">
                        <option value="" disabled selected>Select The College</option>

                        <!-- use php to find all the school name from the data set by using the same method I used on the above
                        for finding all the departments -->
                        <?php
                        $handler = fopen("assets/data/ratemyprofessors.csv", "r");

                        // created a var to avoid print first line of data set
                        $countForFirstLine = 0;

                        // created a var for avoiding repeating the same string
                        $noRepeatWord = "";

                        // use fgetcsv() function to parse the csv file
                        while (($line = fgetcsv($handler)) !== false) {
                            // count is a moving pointer I use
                            $count = 0;

                            // length: 6 cells
                            foreach ($line as $cell) {
                                // when count equals to 6, print the cell -> school name
                                // and it also reaches the end of the column, set to 0, ready for next row
                                // otherwise count++ to iterate through the column
                                if ($count == 6 && $countForFirstLine == 1) {
                                    if (strcmp($noRepeatWord, htmlspecialchars($cell)) !== 0) {

                                        @$school = $_GET["school"];

                                        if (!empty($school) && $cell === $school) {
                                            echo "<option value=\"" . htmlspecialchars($cell) . "\"" . "selected" . ">" .
                                                htmlspecialchars($cell) .
                                                "</option>";
                                        } else {
                                            echo "<option value=\"" . htmlspecialchars($cell) . "\">" .
                                                htmlspecialchars($cell) .
                                                "</option>";
                                        }
                                        $noRepeatWord = htmlspecialchars($cell);
                                    }
                                    $count = 0;
                                } else {
                                    $count++;
                                }
                            }

                            if ($countForFirstLine == 0) {
                                $countForFirstLine++;
                            }
                        }
                        fclose($handler);
                        ?>
                    </select>

                    <input type="submit" name="filterSubmit" value="Filter">

                    <!-- clean the filter result by simply redirect to explore.php, the previous URI was removed -->
                    <a href="explore.php" id="filterCleanButton">Restart</a>
                </form>

            </div>

            <!-- login and sign up -->
            <div class="grid-col-1of3">
                <!-- nav log in button-->
                <button id="sideLoginButton" onclick="location.href='login.php'">Log in</button>
                <!-- nav sign up button-->
                <button id="sideSignUpButton" onclick="location.href='index.php'">Sign Up</button>
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
        echo "<table>";

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