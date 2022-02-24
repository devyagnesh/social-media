<?php

include "../../web_secure/session.php";
if (isset($_POST["crt-btn"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    function GenerateErrorToken()
    {
        $RandomValue = random_bytes(16);
        $MaskValue = md5(hex2bin($RandomValue));

        return $MaskValue;
    }


    if (isset($_POST["tokenReg"]) && $_POST["tokenReg"] === $_SESSION["tr"]) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $BirthDate = (int)$_POST["date"];
        $BirthMonth = (int)$_POST["month"];
        $BirthYear = (int)$_POST["year"];
        $Gender = $_POST["radio"];
        if (empty($firstname) || (!preg_match("/^[a-zA-Z]{3,}$/", $firstname))) {
            $_SESSION["Invalid_Firstname"] = GenerateErrorToken();
            header("Location: ../../index.php?Token=" . $_SESSION["Invalid_Firstname"]);
            exit();
        } else if (empty($lastname) || (!preg_match("/^[a-zA-Z]{3,}$/", $lastname))) {
            $_SESSION["Invalid_Lastname"] = GenerateErrorToken();
            header("Location: ../../index.php?Token=" . $_SESSION["Invalid_Lastname"]);
            exit();
        } else if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $_SESSION["Invalid_Email"] = GenerateErrorToken();
            header("Location: ../../index.php?Token=" . $_SESSION["Invalid_Email"]);
            exit();
        } else if (empty($password) || (strlen($password) < 7)) {
            $_SESSION["Invalid_password"] = GenerateErrorToken();
            header("Location: ../../index.php?Token=" . $_SESSION["Invalid_password"]);
            exit();
        } else if (($BirthDate < 1 || $BirthDate > 31) || ($BirthMonth < 1 || $BirthMonth > 12) || (($BirthYear > 2000) || ((gettype($BirthDate) !== 'integer') || (gettype($BirthMonth) !== 'integer') || (gettype($BirthYear) !== 'integer')))) {
            $_SESSION["Invalid_dob"] = GenerateErrorToken();
            header("Location: ../../index.php?Token=" . $_SESSION["Invalid_dob"]);
            exit();
        } else if ((!isset($Gender))) {
            $_SESSION["Invalid_gender"] = GenerateErrorToken();
            header("Location: ../../index.php?Token=" . $_SESSION["Invalid_gender"]);
            exit();
        } else {
            require_once "class_loader.php";
            $UserView = new View();
            $Boolean = $UserView->CheckEmailExists($email);

            if ($Boolean === true) {
                $_SESSION["Email_Exist"] = GenerateErrorToken();
                header("Location: ../../index.php?Token=" . $_SESSION["Email_Exist"]);
                exit();
            } else if ($Boolean === false) {
                $FullBirthDate = $BirthDate . "-" . $BirthMonth . "-" . $BirthYear;
                $UserControl = new Control();
                $StoreResult = $UserControl->RegisterUser($firstname, $lastname, $email, $password, $FullBirthDate, $Gender);

                if ($StoreResult === true) {

                    $_SESSION["User"] = $email;
                    $_SESSION["Second_Stage"] = 1;
                    // $_SESSION["Is_Login"] = true;
                    // setcookie("UE", bin2hex($email), 86400 * 7, "/", "localhost", false, true);
                    // setcookie("UI", bin2hex($_SESSION["Id"]), 86400 * 7, "/", "localhost", false, true);
                    $_SESSION["hash"] = GenerateErrorToken();
                    if ($Gender === "male") {
                        $_SESSION["tmpMale"] = "Male";
                        mkdir("../../users/male/" . strtoupper($email), 0777, true);
                        mkdir("../../users/male/" . strtoupper($email) . "/profile", 0777, true);
                        mkdir("../../users/male/" . strtoupper($email) . "/photos", 0777, true);
                        mkdir("../../users/male/" . strtoupper($email) . "/background", 0777, true);

                        header("Location: ../security_steps/Step1/Male.php?Hash=" . $_SESSION["hash"]);
                        exit();
                    } else if ($Gender === "female") {
                        $_SESSION["tmpFemale"] = "Female";
                        mkdir("../../users/female/" . strtoupper($email), 0777, true);
                        mkdir("../../users/female/" . strtoupper($email) . "/profile", 0777, true);
                        mkdir("../../users/female/" . strtoupper($email) . "/photos", 0777, true);
                        mkdir("../../users/female/" . strtoupper($email) . "/background", 0777, true);
                        header("Location: ../security_steps/Step1/Female.php?Hash=" . $_SESSION["hash"]);
                        exit();
                    }
                }
            }
        }
    } else {
        header("location: ../../index.php");
        exit();
    }
} else {
    header("location: ../../index.php");
    exit();
}
