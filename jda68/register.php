<html lang="en">

<head>
    <link rel="stylesheet" href="css/forRegister.css">
</head>

<body>

<input type="text" placeholder="Search Prof..." size="50" id="searchBar">

<!-- register button for new users -->
<br>
<button id="startButton" onclick="showForm()">Get Started</button>

<!-- registration form -->
<form action="" method="post" id="registrationForm" style="display: none">
    <input type="email" name="email" value="">
    <br>
    <input type="password" name="password" value="">
    <br>
    <input type="submit" name="sumbit" value="submit">
</form>

<script type="text/javascript">
    // learn how show and hide form from https://www.w3schools.com/howto/howto_js_toggle_hide_show.asp
    function showForm() {
        let registrationForm = document.getElementById("registrationForm");
        let loginButton = document.getElementById("loginButton");

        if (registrationForm.style.display === "none") {
            registrationForm.style.display = "block";
            loginButton.style.display = "none";
        }
    }
</script>

<!-- login button for registered users -->
<br>
<button onclick="location.href='login.php'" id="loginButton">Log In</button>

<!-- a link for visitors to visit -->
<br>
<a href="explore.php">Here's what trending</a>

<footer>
    <a href="">What is ProfRating?</a>
</footer>

</body>
</html>