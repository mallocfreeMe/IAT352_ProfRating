<html lang="en">
<body>

<br>

<?php

@$email = $_POST["email"];
@$password = $_POST["password"];
@$username = $_POST["username"];

if (!empty($email) && !empty($password) && !empty($username)) {
    echo "Welcome to ProRating, !!!!" . $username;
    echo "<br>";
    echo "You just need to click few steps to finish registration";

    $file = "user.txt";
    $handler = fopen($file, "a+");

    if ($handler) {
        $info = $email . ","
            . $password . ","
            . $username
            . "\n";

        fwrite($handler, $info);
        fclose($handler);
    } else {
        echo "No permission to read and write file";
    }
}

?>

</body>
</html>