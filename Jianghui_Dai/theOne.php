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
                <a href="explore.php">
                    <img src="assets/icons/professor.png" class="searchIcon">
                </a>
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">
                <!-- nav log in button-->
                <button id="sideLoginButton" onclick="location.href='login.php'">Log in</button>

                <!-- nav sign up button-->
                <button id="sideSignUpButton" onclick="location.href='index.php'">Sign Up</button>
            </div>

        </div>
    </nav>

</header>

<div class="grid" id="contentGrid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3" id="content">

        <!-- Get the selected row by adding all the information to an array -->
        <?php
        // get the name of the selected professor through GET method
        @$nameEncode = $_GET['name'];

        // create an empty array to store the row
        $array = array("");

        // if encoded name is empty meaning users open this page directly without selecting any professor
        // it will cause fatal error, so the website decides to redirect the users to explore page and kill itself
        if (!empty($nameEncode)) {
            $name = urldecode($nameEncode);

            // open csv file, get the handler
            $handler = fopen("assets/data/ratemyprofessors.csv", "r");

            // if handler is true
            if ($handler) {

                // iterate through the csv file
                // find the line which contains the same name by using in_array function
                // learnt in_array from https://www.php.net/manual/en/function.in-array.php
                while (($line = fgetcsv($handler)) !== false) {
                    $key = in_array($name, $line);

                    // if it finds the line
                    // set the array to the line
                    if ($key) {
                        $array = $line;
                    }
                }

                // close handler
                fclose($handler);
            }

        } else {
            header("Location: explore.php");
            die();
        }
        ?>

        <!-- professor information -->
        <div id="professorProfile" class="grid">

            <div class="grid-col-1of2">
                <img src="assets/icons/male.png">
            </div>

            <div class="grid-col-1of2" id="colOne">
                <p>Professor: <b><?php echo $array[0]; ?></b></p><br>
                <p>Department: <b><?php echo $array[5]; ?></b></p><br>
                <p>College: <b><?php echo $array[6]; ?></b></p><br>
                <p>Overall Quality: <b><?php echo $array[1]; ?></b></p><br>
                <p>Total Ratings: <b><?php echo $array[2]; ?></b></p><br>
                <p>Hotness: <b><?php echo $array[3]; ?></b></p><br>
                <p>Easiness: <b><?php echo $array[4]; ?></b></p><br>
            </div>
        </div>

        <!-- user comment section -->
        <!-- submit to the page the user is visiting -->
        <div id="userCommentSection">
            <textarea placeholder="user comments here"></textarea>
            <button>Submit</button>
        </div>

        <!-- based on total ratings' number to generate comments -->
        <!-- array = 0 -> name, 1 -> overall quality, 2->total ratings, 3->hot, 4->easiness, 5->department, 6->college -->
        <?php
        for ($i = 0; $i < $array[2]; $i++) {
            echo "<textarea readonly>". "This is " . "#" . $i . " comment".
                "</textarea><br>";
        }
        ?>
    </div>

    <div class="grid-col-1of3"></div>

</div>


</body>
</html>
