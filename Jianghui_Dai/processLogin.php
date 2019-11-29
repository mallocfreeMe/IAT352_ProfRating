<!-- This is the page I used to check log in form -->
<?php
// start a session
session_start();

// check and filter data coming from the user
@$email = trim($_POST["email"]);
@$password = trim($_POST["password"]);

// if email and password are both not empty
if (!empty($email) || !empty($password)) {

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

    // escape special chars from user
    if (!get_magic_quotes_gpc()) {
        $password = addslashes($password);
        $email = addslashes($email);
    }

    // query to select user_id from the User table
    $query = "SELECT User.user_id FROM User WHERE User.email = '$email' AND User.password = '$password'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) != 0) {
        // if selection success, go to personalize page
        // add user_id to session
        $array = mysqli_fetch_assoc($result);
        $_SESSION["user_id"] = $array["user_id"];

        mysqli_free_result($result);
        mysqli_close($connection);
        header("Location: private/home.php");
    } else {
        // if selection failed, leave the message
        session_destroy();
        mysqli_close($connection);
        header("Location: login.php");
        die("Database query failed. " . mysqli_error($connection));
    }

} else {
    session_destroy();
    header("Location: login.php");
    die();
}

?>