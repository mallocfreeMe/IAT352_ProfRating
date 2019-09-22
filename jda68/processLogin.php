<html lang="en">
<body>

<?php
@$email = $_POST["email"];
@$password = $_POST["password"];

if (!empty($email) || !empty($password)) {

    $file = "private/user.txt";
    $handler = fopen($file, "r");

    if ($handler) {
        while ($line = fgets($handler) !== false) {
            foreach ($line as $cell) {
                $array = array(
                    "email" => "",
                    "password" => "",
                    "username" => ""
                );

                $rightEmail = $array["email"];
                $rightPassword = $array["password"];
            }

            // find the right match
            if ($array["email"] == $email && $array["password"] == $password) {
                break;
            }
        }

        fclose($handler);
        header("Location: private/personalize.php");
        die();
    } else {
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