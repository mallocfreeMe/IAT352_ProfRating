<html lang="en">
<body>

<!-- This is the page I used to handle registration -->
<?php
@$email = $_POST["email"];
@$password = $_POST["password"];
@$username = $_POST["username"];

// if all input fields from register form are not empty
if (!empty($email) && !empty($password) && !empty($username)) {

    // Create a database connection
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "JianghuiDai";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Test if connection succeeded
    if (mysqli_connect_errno()) {
        // if connection failed, skip the rest of PHP code, and print an error
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_errno() . ")"
        );
    }



} else {
    // if all input fields from register from are empty
    // redirect to the register page, and kill itself
    header("Location: index.php");
    die();
}

?>

</body>
</html>
