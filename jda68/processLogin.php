<html lang="en">
<body>

<?php
@$email = $_POST["email"];
@$password = $_POST["password"];

if (!empty($email) || !empty($password)) {

    $file = "private/user.txt";
    $handler = fopen($file, "r");

    if ($handler) {
        while (!feof($handler)) {
            $array = explode(',', fgets($handler));
            // find the right match
            if ($array["0"] == $email && $array["1"] == $password) {
                fclose($handler);

                // pass name to personalize page through url
                $string = "Location: private/personalize.php?name=" . $array[2];
                header($string);
                die();
            }
        }
        // did not find the right match, go back to log in page
        fclose($handler);
        header("Location: login.php");
        die();
    }
} else {
    header("Location: login.php");
    die();
}

?>

</body>
</html>