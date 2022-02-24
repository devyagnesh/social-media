<?php
include "web_secure/session.php";
include "web_secure/TokenGen.php";

if (isset($_SESSION["Second_Stage"])) {
    if ($_SESSION["Second_Stage"] === 1) {
        if (isset($_SESSION["tmpMale"]) && $_SESSION["tmpMale"] === "Male") {
            header("location: web_backend/security_steps/Step1/Male.php?Hash=" . $_SESSION["hash"]);
            exit();
        } else if (isset($_SESSION["tmpFemale"]) && $_SESSION["tmpFemale"] === "Female") {
            header("location: web_backend/security_steps/Step1/Female.php?Hash=" . $_SESSION["hash"]);
            exit();
        }
    } else {
        if ($_SESSION["Second_Stage"] === (int)2) {
            header("Location: web_backend/security_steps/Step2/Securityquestions.php?Hash=" . $_SESSION["SqHash"]);
            exit();
        }
    }
} else if ((isset($_SESSION["LogedIN"]) && $_SESSION["LogedIN"] = (bool)true && isset($_COOKIE["CULS"]) && ((bool)$_COOKIE["CULS"] === (bool)$_SESSION["LogedIN"])) && isset($_SESSION["USER_ID"]) && isset($_COOKIE["CUI"]) && $_COOKIE["CUI"] === bin2hex($_SESSION["USER_ID"]) && isset($_SESSION["Current_User_Token"]) && isset($_COOKIE["CUT"]) && $_COOKIE["CUT"] === bin2hex($_SESSION["Current_User_Token"])) {
    header("Location: web_backend/Feed/Feed.php?Hash=" . $_SESSION["Current_User_Token"]);
    exit();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='shortcut icon' type='image/x-icon' href='web_backend/Assest/favicon.ico' />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="front_css/style.css" type="text/css">
    <title>Social Media</title>
</head>

<body>
    <div id="signup-wrapper">
        <div class="signup-box">
            <div class="signup-box___header mb-20">
                <h2>Create New Account
                    <p>It's Free</p>
                </h2>
                <button type="button" class="btn btn-close"><span class="material-icons">close</span></button>
            </div>
            <hr class="mt-20 mb-20">
            <form action="web_backend/includes/user_signup.php" method="POST" autocomplete="off" aria-autocomplete="off">
                <div class="row">
                    <div class="form-group mr-10">
                        <label for="firstname" class="mb-10">First Name : </label>

                        <div class="input-wrappers">
                            <input type="text" name="firstname" id="firstname" class="controller" />
                            <span class="material-icons">person</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="mb-10">Last Name : </label>

                        <div class="input-wrappers">
                            <input type="text" name="lastname" id="lastname" class="controller" />
                            <span class="material-icons">person</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-20">
                    <label for="email" class="mb-10">Your Email : </label>

                    <div class="input-wrappers">
                        <input type="email" name="email" id="email" class="controller" />
                        <span class="material-icons">mail</span>
                    </div>
                </div>

                <div class="form-group mt-20">
                    <label for="password" class="mb-10">Create Password : </label>

                    <div class="input-wrappers">
                        <input type="password" name="password" id="password" class="controller" />
                        <span class="material-icons" id="seepass">lock</span>
                    </div>
                </div>

                <div class="form-group mt-20">
                    <label for="pd" class="mb-10">Select Date Of Birth :</label>
                    <div class="row space-between">
                        <div class="col f-grow-1 mr-10">
                            <select name="date" id="date" class="select pad-10 w-100">
                                <option>Date</option>
                                <script>
                                    for (let i = 1; i <= 31; i++) {
                                        document.write("<option value='" + i + "'>" + i + "</option>");
                                    }
                                </script>
                            </select>
                        </div>

                        <div class="col f-grow-1 mr-10">
                            <select name="month" id="month" class="select pad-10 w-100">
                                <option>Month</option>
                                <script>
                                    for (let j = 1; j <= 12; j++) {
                                        document.write("<option value='" + j + "'>" + j + "</option>");
                                    }
                                </script>
                            </select>
                        </div>

                        <div class="col f-grow-1">
                            <select name="year" id="year" class="select pad-10 w-100">
                                <option>Year</option>
                                <script>
                                    for (let k = 1901; k <= 2000; k++) {
                                        document.write("<option value='" + k + "'>" + k + "</option>");
                                    }
                                </script>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-20">
                    <label for="">Choose Gender :</label>
                    <div class="row">
                        <div class="col mr-20">
                            <div class="row">

                                <label for="malecheck" class="checkbox-selector">
                                    <input type="radio" name="radio" id="malecheck" value="male" class="mr-10" />
                                    <div class="row">
                                        <span class="mark mr-10"></span>
                                        Male
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">

                                <label for="femalecheck" class="checkbox-selector">
                                    <input type="radio" name="radio" id="femalecheck" value="female" class="mr-10" />
                                    <div class="row">
                                        <span class="mark mr-10"></span>
                                        Female
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="crt-btn" id="crt-btn" class="btn btn-crt mt-20">Create Account</button>
                <input type="hidden" name="tokenReg" id="TokenReg" value="<?php $_SESSION["tr"] = TokenGenerate();
                                                                            echo $_SESSION["tr"]; ?>" />
            </form>
        </div>
    </div>

    <div id="container">
        <div class="wrapper">
            <div class="wrapper___logo height-100">
                <h2 class="logo___text">Social Media</h2>
            </div>

            <div class="wrapper___userInteraction height-100">
                <div class="userInteractLogin">
                    <?php
                    // var_dump($_SESSION);
                    if (isset($_SESSION["Login_Empty_Value"]) && isset($_GET["Token"])) {
                        if ($_GET["Token"] === $_SESSION["Login_Empty_Value"]) {
                            echo "<div class='alert-notification alert-bg alert-border '>" . "<p>Enter Email Or Password !</p>" . "</div>";
                            unset($_SESSION["Login_Empty_Value"]);
                        }
                    } else if (isset($_SESSION["Login_Invalid_Email"]) && isset($_GET["Token"])) {
                        if ($_GET["Token"] === $_SESSION["Login_Invalid_Email"]) {
                            echo "<div class='alert-notification alert-bg alert-border '>" . "<p>Invalid Email !</p>" . "</div>";
                        }
                    } else if (isset($_SESSION["Login_Email_Not_Exist"]) && isset($_GET["Token"])) {
                        if ($_GET["Token"] === $_SESSION["Login_Email_Not_Exist"]) {
                            echo "<div class='alert-notification alert-bg alert-border '>" . "<p>Email Does Not Exist</p>" . "</div>";
                        }
                    } else if (isset($_SESSION["Login_Pass_Not_Match"]) && isset($_GET["Token"])) {
                        if ($_GET["Token"] === $_SESSION["Login_Pass_Not_Match"]) {
                            echo "<div class='alert-notification alert-bg alert-border '>" . "<p>Incorrect Password</p>" . "</div>";
                        }
                    }
                    ?>
                    <form action="web_backend/includes/userlogin.php" method="POST" autocomplete="off">
                        <div class="form-group">
                            <label for="Login-Email" class="mb-10">Email :</label>
                            <div class="input-wrappers">
                                <input type="text" name="Login-Email" id="Login-Email" class="controller" />
                                <span class="material-icons">mail</span>
                            </div>
                        </div>

                        <div class="form-group mt-20">
                            <label for="Login-Password" class="mb-10">Enter Password :</label>
                            <div class="input-wrappers">
                                <input type="password" name="Login-Password" id="Login-Password" class="controller" />
                                <span class="material-icons">
                                    lock
                                </span>
                            </div>
                        </div>

                        <div class="form-group mt-20">
                            <button type="submit" name="LoginBtn" id="LoginBtn" class="btn btn-login">Login</button>
                            <input type="hidden" name="tokenLog" id="TokenLog" value="<?php $_SESSION["tl"] = TokenGenerate();
                                                                                        echo $_SESSION["tl"]; ?>" />
                        </div>
                    </form>
                    <p class="frgt-pwd mt-20">Forget Password ? <a href="">Reset Now</a></p>
                    <button type="button" name="Btn-Signup" id="Btn-Signup" class="btn btn-signup mt-20">Create Account</button>
                </div>


            </div>
        </div>
    </div>

    <script src="front_js/app.js"></script>
</body>

</html>