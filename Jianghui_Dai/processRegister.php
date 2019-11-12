<html lang="en">
<body>

<!-- This is the page I used to handle registration -->
<?php
// check and filter data coming from the user
@$email = trim($_POST["email"]);
@$password = trim($_POST["password"]);
@$username = trim($_POST["username"]);

// if all input fields from register form are not empty
if (!empty($email) && !empty($password) && !empty($username)) {

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
        $username = addslashes($username);
        $password = addslashes($password);
        $email = addslashes($email);
    }

    // query to insert user info to the User table
    $query = "INSERT INTO User (username, password, email) VALUES ('$username', '$password', '$email')";

    $result = mysqli_query($connection, $query);

    if ($result) {
        // if insert success, go to personalize page
        header("Location: private/home.php");
    } else {
        // if insert failed, leave the message
        die("Database query failed. " . mysqli_error($connection));
    }

    // Close database connection
    mysqli_close($connection);

} else {
    // if all input fields from register from are empty
    // redirect to the register page, and kill itself
    header("Location: index.php");
    die();
}

?>

</body>
</html>
