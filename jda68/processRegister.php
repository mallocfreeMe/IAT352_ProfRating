<html lang="en">
<body>

<?php
@$email = $_POST["email"];
@$password = $_POST["password"];
@$username = $_POST["username"];

if (!empty($email) && !empty($password) && !empty($username)) {

    $file = "private/user.txt";
    $handler = fopen($file, "a+");

    if ($handler) {
        $info = $email . ","
            . $password . ","
            . $username
            . "\n";

        fwrite($handler, $info);
        fclose($handler);

        $string = "Location: private/personalize.php?name=" . $username;
        header($string);
        die();
    } else {
        header("Location: register.php");
        die();
    }
} else {
    header("Location: register.php");
    die();
}

?>

</body>
</html>
