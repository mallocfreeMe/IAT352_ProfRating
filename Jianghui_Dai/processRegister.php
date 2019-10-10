<html lang="en">
<body>

<!-- This is the page I used to handle register page -->
<?php
@$email = $_POST["email"];
@$password = $_POST["password"];
@$username = $_POST["username"];

// if all input fields from register form are not empty
if (!empty($email) && !empty($password) && !empty($username)) {

    $file = "private/user.txt";
    $handler = fopen($file, "a+");

    // open handler
    if ($handler) {
        $info = $email . ","
            . $password . ","
            . $username
            . "\n";

        // write into file and close the file
        fwrite($handler, $info);
        fclose($handler);

        // redirect to personalize page since the validation was passed
        // close this page
        $string = "Location: private/personalize.php?name=" . $username;
        header($string);
        die();
    } else {
        // if file cannot be opened
        // redirect to the register page, and kill itself
        header("Location: index.php");
        die();
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
