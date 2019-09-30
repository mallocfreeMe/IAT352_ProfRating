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

<div class="grid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3" id="content">
        <?php
        @$theOneIndex = $_GET['id'];

        if (is_numeric($theOneIndex)) {
            $test = fopen("assets/data/ratemyprofessors.csv", "r");

            $testIndex = 0;
            while (($line = fgetcsv($test)) !== false) {
                if ($testIndex == $theOneIndex) {
                    foreach ($line as $cell) {
                        // length: 6 cells
                        echo htmlspecialchars($cell) . "<br>";
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
        ?>

    </div>

    <div class="grid-col-1of3"></div>

</div>


</body>
</html>
