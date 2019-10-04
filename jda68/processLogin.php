<html lang="en">
<body>

<!-- This is the page I used to check log in form -->
<?php
@$email = $_POST["email"];
@$password = $_POST["password"];

// if email and password are both not empty
if (!empty($email) || !empty($password)) {

    // open the .txt file
    $file = "private/user.txt";
    $handler = fopen($file, "r");

    if ($handler) {
        // read the file until it reaches to the end
        while (!feof($handler)) {
            // remove all the ',' from the array
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