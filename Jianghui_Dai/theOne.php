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
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">
                <?php
                if ($login) {
                    echo "<ul id='loginMenu'>";
                    echo "<li><a href=\"index.php\">Log Out</a></li>";
                    echo "<li><a href=\"private/settings.php\">Settings</a></li>";
                    echo "<li><a href=\"explore.php\">Home</a></li>";
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

<div class="grid" id="contentGrid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3" id="content">

        <!-- Get the selected row by adding all the information to an array -->
        <?php
        // get the Professor_id of the selected professor through GET method
        @$idEncode = $_GET['Professor_id'];

        // create an empty array to store the row
        $array = array("");

        // if encoded Professor_id is empty meaning users open this page directly without selecting any professor
        // it will cause fatal error, so the website decides to redirect the users to explore page and kill itself
        if (!empty($idEncode)) {
            $professor_id = urldecode($idEncode);

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

            // query to select the selected professor from the Professor table
            $query = "SELECT * FROM Professor WHERE Professor_id = '$professor_id'";

            $result = mysqli_query($connection, $query);

            // if no rows are selected, query failed, print the error message
            // go back to explore.php
            if (mysqli_num_rows($result) == 0) {
                header("Location: explore.php");
                die("Database query failed. " . mysqli_error($connection));
            } else {
                // assign the assoc array to array variable
                $array = mysqli_fetch_assoc($result);
            }

            // release returned data
            mysqli_free_result($result);

            // close the connection
            mysqli_close($connection);

        } else {
            mysqli_close($connection);
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
                <p>Professor: <b><?php echo $array['NAME']; ?></b></p><br>
                <p>Department: <b><?php echo $array['Overall_Quality']; ?></b></p><br>
                <p>College: <b><?php echo $array['Total_Ratings']; ?></b></p><br>
                <p>Overall Quality: <b><?php echo $array['Hot']; ?></b></p><br>
                <p>Total Ratings: <b><?php echo $array['Easiness']; ?></b></p><br>
                <p>Hotness: <b><?php echo $array['Department']; ?></b></p><br>
                <p>Easiness: <b><?php echo $array['College']; ?></b></p><br>
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
        for ($i = 0; $i < $array['Total_Ratings']; $i++) {
            echo "<textarea readonly>" . "This is " . "#" . $i . " comment" .
                "</textarea><br>";
        }
        ?>
    </div>

    <div class="grid-col-1of3"></div>

</div>


</body>
</html>
