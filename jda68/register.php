<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/forRegister.css">
</head>

<body>


<!-- Navigation Menu-->
<nav class="navigation">
    <figure>
        <img src="assets/images/logoHead.png" class="searchIcon">
    </figure>

    <input type="text" placeholder="Search Prof" size="50" id="searchBar">

    <button id="sideLoginButton" style="display: none" onclick="location.href='login.php'">Log in</button>
</nav>

<!-- First page-->
<section>
    <div class="firstPage">

        <div class="topPart">

            <!-- icon -->
            <figure>
                <img src="assets/images/logo.png" class="registerIcon">
            </figure>

            <p>Join us, find the professor you are looking for.</p>

            <!-- register button for new users -->
            <br>
            <button id="startButton" onclick="showForm()">Get Started</button>

            <!-- registration form -->
            <form action="processRegister.php" method="post" id="registrationForm" style="display: none">

                <input type="email" name="email" placeholder="Email">
                <br>

                <input type="password" name="password" placeholder="Password">
                <br>

                <input type="text" name="username" placeholder="Username">
                <br>

                <input type="submit" name="submit" value="Sign up">
            </form>

            <script type="text/javascript">
                // learn how show and hide form from https://www.w3schools.com/howto/howto_js_toggle_hide_show.asp
                function showForm() {
                    let registrationForm = document.getElementById("registrationForm");
                    let loginButton = document.getElementById("loginButton");
                    let startButton = document.getElementById("startButton");
                    let sideLoginButton = document.getElementById("sideLoginButton");

                    if (registrationForm.style.display === "none") {
                        registrationForm.style.display = "block";
                        loginButton.style.display = "none";
                        sideLoginButton.style.display = "block";
                    }

                    startButton.style.display = "none";
                }
            </script>

            <!-- login button for registered users -->
            <br>
            <button onclick="location.href='login.php'" id="loginButton">Log In</button>

            <!-- a link for visitors to visit -->
            <br>
            <a href="explore.php" class="visitorLink">Here's what trending</a>

        </div>

        <!-- footer -->
        <!-- An internal link to the second page -->
        <footer>
            <a href="#definition">What is ProfRating?</a>
        </footer>
    </div>
</section>

<!-- Second Page -->
<section>
    <div class="secondPage" id="definition">
        <h2>This is page 2</h2>
    </div>
</section>

<!-- Third Page -->
<section>
    <div class="thirdPage">
        <h2>This is page 3</h2>
    </div>
</section>

</body>
</html>