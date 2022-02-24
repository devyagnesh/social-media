<?php
include "../../../web_secure/session.php";
include "../../../web_secure/TokenGen.php";

if (isset($_POST["sqa_submit"]) && isset($_SESSION["Sq_Token"]) && (isset($_POST["token"]) && ($_POST["token"] === $_SESSION["Sq_Token"])) && $_SERVER["REQUEST_METHOD"] === "POST") {

    $QuestionsArr = ["What Is Your Cousin Name ?", "What Is Your Hobby ?", "Which Food Do You Like The Most ?", "Which Food Do You Like The Most ?", "Last Place That You Have Visited ?", "What Is Your Childhood Name ?"];
    $SelectedQuestion = $_POST["security_perform"];
    $UserAnswer = $_POST["sq_answer"];

    if (in_array($SelectedQuestion, $QuestionsArr) !== true) {
        $_SESSION["OUT_CONTEXT_QUE"] = TokenGenerate();
        header("location: ../Step2/Securityquestions.php?Hash=" . $_SESSION["SqHash"] . "&Token=" . $_SESSION["OUT_CONTEXT_QUE"]);
        exit();
    } else {
        include "../../includes/class_loader.php";
        $ViewObject = new View();
        $Result = $ViewObject->FetchCountQuestions($_SESSION["USER_ID"]);

        if ($Result === 0 || $Result < 1) {
            $AddQuestionObject = new Control();
            $AddResult = $AddQuestionObject->AddSecurityQue($_SESSION["USER_ID"], $SelectedQuestion, $UserAnswer);

            if ($AddResult === true) {
                unset($_SESSION["Second_Stage"]);
                unset($_SESSION["tmpMale"]);
                unset($_SESSION["tmpFemale"]);
                unset($_SESSION["SqHash"]);
                $_SESSION["LogedIN"] = true;
                $_SESSION["Current_User_Token"] = TokenGenerate();
                setcookie("CUI", bin2hex($_SESSION["USER_ID"]),60*60*24*10, "/", "snapters.com", true, true);
                setcookie("CUT", bin2hex($_SESSION["Current_User_Token"]),60*60*24*10, "/", "snapters.com", true, true);
                setcookie("CULS", (bool)$_SESSION["LogedIN"],60*60*24*10, "/", "snapters.com", true, true);
                header("Location: ../../Feed/Feed.php?Hash=" . $_SESSION["Current_User_Token"]);
            }
        } else {
            $_SESSION["Current_User_Token"] = TokenGenerate();
            header("Location: ../../Feed/Feed.php?Hash=" . $_SESSION["Current_User_Token"]);
            exit();
        }
    }
} else {
    header("Location: ../../../../../index.php");
    exit();
}
