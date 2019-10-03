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
            <div class="grid-col-1of3" id="filterCol">

                <form action="explore.php" method="get">

                    <?php
                    @$hotness = $_GET["hotness"];
                    if (!empty($hotness)) {
                        if ($hotness === "Hot") {
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

                    <select name="department">
                        <!-- learnt how to add placeholder for select input from
                        https://stackoverflow.com/questions/5805059/how-do-i-make-a-placeholder-for-a-select-box-->
                        <option value="" disabled selected>Select The Department</option>

                        <!-- use php to find all the department -->
                        <?php
                        // learn how to load csv file in php from
                        // https://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
                        $f = fopen("assets/data/ratemyprofessors.csv", "r");

                        // created a var to avoid print first line of data set
                        $countForFirstLine = 0;

                        // created a var for avoiding repeating the same string
                        $noRepeatWordArray = array("test");

                        // use fgetcsv() function to parse the csv file
                        while (($line = fgetcsv($f)) !== false) {
                            // count is a moving pointer I use
                            $count = 0;

                            // length: 6 cells
                            foreach ($line as $cell) {
                                // when count equals to 5, it reaches department column. Print the cell, count move one cell forward
                                // when count equals to 6, it reaches the end of the column, set to 0, ready for next row
                                // otherwise count++ to iterate through the column
                                if ($count == 5 && $countForFirstLine == 1) {

                                    $repeat = false;

                                    foreach ($noRepeatWordArray as $word) {
                                        $filterResult = strcmp($word, htmlspecialchars($cell));
                                        if ($filterResult == 0) {
                                            $repeat = true;
                                            break;
                                        }
                                    }

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

                            if ($countForFirstLine == 0) {
                                $countForFirstLine++;
                            }
                        }
                        fclose($f);

                        // remove 'test' word I added in the beginning when I created the $noRepeatWordArray
                        if (($key = array_search('test', $noRepeatWordArray)) !== false) {
                            unset($noRepeatWordArray[$key]);
                        }

                        // use asort to sort the array alphabetically
                        asort($noRepeatWordArray);

                        // print all the department

                        @$department = $_GET["department"];
                        foreach ($noRepeatWordArray as $cell) {
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

                    <select name="school">
                        <option value="" disabled selected>Select The College</option>

                        <!-- use php to find all the school name from the data set by using the same method I used on the above
                        for finding all the departments -->
                        <?php
                        $f = fopen("assets/data/ratemyprofessors.csv", "r");

                        // created a var to avoid print first line of data set
                        $countForFirstLine = 0;

                        // created a var for avoiding repeating the same string
                        $noRepeatWord = "";

                        // use fgetcsv() function to parse the csv file
                        while (($line = fgetcsv($f)) !== false) {
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
                        fclose($f);
                        ?>
                    </select>

                    <input type="submit" name="filterSubmit" value="Filter">
                    <a href="explore.php" id="filterCleanButton">Clean</a>
                </form>

            </div>

            <!-- login and sign up -->
            <div class="grid-col-1of3">
                <!-- nav log in button-->
                <button id="sideLoginButton" onclick="location.href='login.php'">Log in</button>
                <!-- nav sign up button-->
                <button id="sideSignUpButton" onclick="location.href='register.php'">Sign Up</button>
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
        $f = fopen("assets/data/ratemyprofessors.csv", "r");

        // created a var to avoid print first line of data set
        $countForFirstLine = 0;

        // create a index var for the each professor, and pass it to the theOne page through url
        $index = 0;

        // get the filter form's fields values through GET
        // filter form -> hotness, department, school, filterSubmit
        @$hotness = $_GET["hotness"];
        @$department = $_GET["department"];
        @$school = $_GET["school"];
        @$filterSubmit = $_GET["filterSubmit"];

        $filterResult = true;

        // use fgetcsv() function to parse the csv file
        while (($line = fgetcsv($f)) !== false) {

            // check if the filter form is submitted or not
            if (!empty($filterSubmit)) {

                // get the radio button value -> hot or not hot
                if (!empty($hotness)) {
                    $key = array_search($hotness, $line);
                    if ($key == false) {
                        $filterResult = false;
                    }
                }

                if (!empty($department)) {
                    $key = array_search($department, $line);
                    if ($key == false) {
                        $filterResult = false;
                    }
                }

                if (!empty($school)) {
                    $key = array_search($school, $line);
                    if ($key == false) {
                        $filterResult = false;
                    }
                }
            }

            if ($filterResult != false) {
                echo "<tr>";

                // count is a moving pointer I use
                $count = 0;

                // iterate though the array - $line
                foreach ($line as $cell) {
                    // length: 6 cells

                    if ($count == 0 && $countForFirstLine == 1) {
                        echo "<td><a href='theOne.php?id="
                            . $index
                            . "'>"
                            . htmlspecialchars($cell)
                            . "</a></td>";
                    } else {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
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

                $index++;
                echo "</tr>\n";
            }

            $filterResult = true;
        }

        fclose($f);
        echo "</table>";
        ?>
    </div>

    <div class="grid-col-1of3"></div>

</div>

</body>
</html>
