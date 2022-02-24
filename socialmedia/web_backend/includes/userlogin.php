<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require "../../web_secure/session.php";
require "../../web_secure/TokenGen.php";

if (isset($_POST["LoginBtn"]) && isset($_POST["tokenLog"]) && isset($_SESSION["tl"]) && $_POST["tokenLog"] === $_SESSION["tl"] && $_SERVER["REQUEST_METHOD"] === "POST") {

    $LoginEmail = filter_var($_POST["Login-Email"], FILTER_SANITIZE_EMAIL);
    $LoginPassword = $_POST["Login-Password"];

    if (empty($LoginEmail) || empty($LoginPassword)) {
        $_SESSION["Login_Empty_Value"] = TokenGenerate();
        header("Location: ../../index.php?Token=" . $_SESSION["Login_Empty_Value"]);
        exit();
    } else if (!filter_var($LoginEmail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["Login_Invalid_Email"] = TokenGenerate();
        header("Location: ../../index.php?Token=" . $_SESSION["Login_Invalid_Email"]);
        exit();
    } else {
        require "class_loader.php";
        $PasswordCheckObject = new View();
        $GetEncryptedData = $PasswordCheckObject->FetchUserDatas($LoginEmail);

        if (is_null($GetEncryptedData) !== true) {
            if ($LoginEmail !== $GetEncryptedData[3]) {
                $_SESSION["Login_Email_Not_Exist"] = TokenGenerate();
                header("Location: ../../index.php?Token=" . $_SESSION["Login_Email_Not_Exist"]);
                exit();
            } else {
                if (password_verify($LoginPassword, $GetEncryptedData[4]) !== true) {
                    $_SESSION["Login_Pass_Not_Match"] = TokenGenerate();
                    header("Location: ../../index.php?Token=" . $_SESSION["Login_Pass_Not_Match"]);
                    exit();
                } else if (password_verify($LoginPassword, $GetEncryptedData[4]) !== false) {
                    $_SESSION["User"] = $LoginEmail;
                    $_SESSION["USER_ID"] = $GetEncryptedData[0];
                    $GetProfileCounts = $PasswordCheckObject->CountRowProfiles($_SESSION["USER_ID"]);
                    $GetGender = $GetEncryptedData[6];
                    $_SESSION["hash"] = TokenGenerate();
                    if ($GetProfileCounts === 0) {
                        $_SESSION["Second_Stage"] = 1;
                        if ($GetGender === "male") {
                            $_SESSION["tmpMale"] = "Male";
                            $_SESSION["Second_Stage"] = 1;
                            header("Location: ../security_steps/Step1/Male.php?Hash=" . $_SESSION["hash"]);
                            exit();
                        } else if ($GetGender === "female") {
                            $_SESSION["tmpFemale"] = "Female";
                            $_SESSION["Second_Stage"] = 1;
                            header("Location: ../security_steps/Step1/Female.php?Hash=" . $_SESSION["hash"]);
                            exit();
                        }
                    } else {
                        $GetSecurityQuestion = $PasswordCheckObject->FetchCountQuestions($_SESSION["USER_ID"], "iwantcount");

                        if ($GetSecurityQuestion === 0) {
                            $_SESSION["Second_Stage"] = 2;
                            $_SESSION["SqHash"] = TokenGenerate();
                            header("Location: ../security_steps/Step2/Securityquestions.php?Hash=" . $_SESSION["SqHash"]);
                            exit();
                        } else {
                            unset($_SESSION["Second_Stage"]);
                            unset($_SESSION["tmpMale"]);
                            unset($_SESSION["tmpFemale"]);
                            unset($_SESSION["SqHash"]);
                            $_SESSION["LogedIN"] = true;
                            $_SESSION["Current_User_Token"] = TokenGenerate();
                            setcookie("CUI", bin2hex($_SESSION["USER_ID"]),60*60*24*10, "/", "snapters.com", true, true);
                            setcookie("CUT", bin2hex($_SESSION["Current_User_Token"]), 60*60*24*10, "/", "snapters.com", false, true);
                            setcookie("CULS", (bool)$_SESSION["LogedIN"], 60*60*24*10, "/", "snapters.com", false, true);
                            header("Location: ../Feed/Feed.php?Hash=" . $_SESSION["Current_User_Token"]);
                        }
                    }
                }
            }
        }
    }
} else {
    header("location: ../../index.php");
    exit();
}
