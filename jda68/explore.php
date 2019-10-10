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
        <!-- table -->
        <?php
        echo "<table>";

        // learn how to load csv file in php from
        // https://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
        $handler = fopen("assets/data/ratemyprofessors.csv", "r");

        // created a var to avoid print first line of data set
        // create a index var for the each professor, and pass it to the theOne page through url
        $countForFirstLine = 0;
        $index = " ";

        // get the filter form's fields values through GET
        // filter form -> hotness, department, school, filterSubmit
        @$hotness = $_GET["hotness"];
        @$department = $_GET["department"];
        @$school = $_GET["school"];
        @$filterSubmit = $_GET["filterSubmit"];

        // created a var as bool state
        $filterResult = true;

        // use fgetcsv() function to parse the csv file
        while (($line = fgetcsv($handler)) !== false) {

            // check if the filter form is submitted or not
            if (!empty($filterSubmit)) {

                // search hotness value in each line
                // if it not find the hotness value from the line, set the filerResult to false meaning the line will be censored
                if (!empty($hotness)) {
                    $key = array_search($hotness, $line);
                    if ($key == false) {
                        $filterResult = false;
                    }
                }

                // search department value in each line
                // if it not find the department value from the line, set the filerResult to false meaning the line will be censored
                if (!empty($department)) {
                    $key = array_search($department, $line);
                    if ($key == false) {
                        $filterResult = false;
                    }
                }

                // search school value in each line
                // if it not find the school value from the line, set the filerResult to false meaning the line will be censored
                if (!empty($school)) {
                    $key = array_search($school, $line);
                    if ($key == false) {
                        $filterResult = false;
                    }
                }

                // search the table head by searing the keywords "Department"
                // if it finds the table head, print it without adding link
                $searchForFirstLine = array_search("Department", $line);
                if ($searchForFirstLine == true) {
                    echo "<tr>";
                    foreach ($line as $cell) {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
                    }
                    echo "</tr>\n";
                }
            }

            // when filterResult equals to false meaning this line need to be printed
            if ($filterResult != false) {
                echo "<tr>";

                // count is a moving pointer I use
                $count = 0;

                // create these vars for filter link
                $countForFilterIndex = 0;
                $filterIndex = " ";

                // iterate though the array - $line
                foreach ($line as $cell) {
                    // length: 6 cells

                    // if filter form is not submitted yet
                    if (empty($filterSubmit)) {
                        // print each $cell from the line, and add link to the first cell which is professor's name
                        // the link is to theOne.php page
                        // the URI followed with professor's name
                        if ($count == 0 && $countForFirstLine == 1) {
                            $index = $cell;
                            // encode the name by using urlendcode function
                            // which I learnt from https://www.php.net/manual/en/function.urlencode.php
                            echo "<td><a href='theOne.php?name="
                                . urlencode($index)
                                . "'>"
                                . htmlspecialchars($cell)
                                . "</a></td>";
                        } else {
                            // else print the table head without adding the link
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                    } else {
                        // if filter form is submitted
                        // echo all the cell, add hyper link to the first cell which professor's name
                        if ($countForFilterIndex == 0) {
                            $filterIndex = $cell;
                            echo "<td><a href='theOne.php?name="
                                . urlencode($filterIndex)
                                . "'>"
                                . htmlspecialchars($cell)
                                . "</a></td>";
                        } else {
                            // print other cells without links
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }

                        $countForFilterIndex++;
                    }

                    if ($count <= 5) {
                        $count++;
                    } else {
                        $count = 0;
                    }
                }

                if ($countForFirstLine == 0) {
                    $countForFirstLine++;
                }

                echo "</tr>\n";
            }

            $filterResult = true;
        }

        fclose($handler);
        echo "</table>";
        ?>
    </div>

    <div class="grid-col-1of3"></div>

</div>

</body>
</html>