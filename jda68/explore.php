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

<div class="grid" id="table">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">
        <?php
        // https://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
        echo "<table>\n\n";
        $f = fopen("assets/data/ratemyprofessors.csv", "r");

        $countForFirstLine = 0;
        $index = 0;
        while (($line = fgetcsv($f)) !== false) {
            echo "<tr>";
            $count = 0;

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
        fclose($f);
        echo "\n</table>";
        ?>
    </div>

    <div class="grid-col-1of3"></div>

</div>

</body>
</html>
