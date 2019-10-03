<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="assets/icons/favicon.png"/>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/publicNavigationBar.css">
    <link rel="stylesheet" href="css/forTheOne.css">
</head>

<body>

<header>

    <nav>
        <div class="grid">

            <div class="grid-col-1of3">
                <img src="assets/icons/professor.png" class="searchIcon">
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">
                <!-- nav log in button-->
                <button id="sideLoginButton" onclick="location.href='login.php'">Log in</button>

                <!-- nav sign up button-->
                <button id="sideSignUpButton" onclick="location.href='register.php'">Sign Up</button>
            </div>

        </div>
    </nav>

</header>

<div class="grid" id="contentGrid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3" id="content">
        <!-- Professor name -->
        <div class="card">

            <img src="assets/icons/male.png" alt="Avatar" style="width:100%">

            <div class="container">

                <?php

                echo "<h4><b>";
                // get the id through url
                @$theOneIndex = $_GET['id'];

                if (is_numeric($theOneIndex)) {
                    $test = fopen("assets/data/ratemyprofessors.csv", "r");

                    $testIndex = 0;
                    while (($line = fgetcsv($test)) !== false) {

                        if ($testIndex == $theOneIndex) {
                            // length: 6 cells
                            $name = htmlspecialchars($line[0]);
                            // remove any "," in the name field
                            $name = str_replace(",", " ", $name);
                            echo $name;
                            break;
                        }

                        $testIndex++;
                    }

                    fclose($test);
                } else {
                    header("Location: explore.php");
                    die();
                }
                echo "</b></h4>";

                ?>
                <p>Professor</p>
            </div>

        </div>

        <?php

        echo "<ul id='contentList'>";
        // get the id through url
        @$theOneIndex = $_GET['id'];

        if (is_numeric($theOneIndex)) {
            $test = fopen("assets/data/ratemyprofessors.csv", "r");

            $firstLine = array();

            $testIndex = 0;
            while (($line = fgetcsv($test)) !== false) {
                // get the first line of csv file
                if ($testIndex == 0) {
                    $firstLine = $line;
                }

                if ($testIndex == $theOneIndex) {
                    // length: 6 cells
                    for ($cell = 1; $cell < count($firstLine); $cell++) {
                        echo "<li>" .
                            htmlspecialchars($firstLine[$cell]) .
                            ":" . " " .
                            htmlspecialchars($line[$cell]) .
                            "</li>";
                    }

                    break;
                }

                $testIndex++;
            }

            fclose($test);
        } else {
            header("Location: explore.php");
            die();
        }
        echo "</ul>";

        ?>

        <!-- generate comment sections based on Total Ratings -->
        <?php

        if (is_numeric($theOneIndex)) {
            $test = fopen("assets/data/ratemyprofessors.csv", "r");

            $testIndex = 0;
            $numberOfComments = 0;
            while (($line = fgetcsv($test)) !== false) {
                if ($testIndex == $theOneIndex) {
                    // length: 6 cells
                    $numberOfComments = $line[2];
                    break;
                }
                $testIndex++;
            }
            fclose($test);

            for ($i = 0; $i < $numberOfComments; $i++) {
                echo "<textarea readonly>This is a comment.</textarea><br>";
            }
        }

        ?>
    </div>

    <div class="grid-col-1of3"></div>

</div>


</body>
</html>
