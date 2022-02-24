<?php
include "../../../web_secure/session.php";
if (isset($_POST["Profile-updater-btn"]) && (isset($_SESSION["Second_Stage"]) && $_SESSION["Second_Stage"] === 1)) {
    include "../../../web_secure/TokenGen.php";
    require "../../includes/class_loader.php";


    $SelectedImage = $_FILES["ProfileFile"];
    $ImageName = $SelectedImage["name"];
    $ImageHasError = $SelectedImage['error'];
    $ImageTemp = $SelectedImage["tmp_name"];
    $ImageType = $SelectedImage["type"];
    $ImageExtension = explode(".", $ImageName);
    $ImageCheck =  strtolower(end($ImageExtension));
    $Allowed_Extensions = array("jpg", "jpeg");

    if (in_array($ImageCheck, $Allowed_Extensions)) {

        if (isset($_SESSION["tmpFemale"]) && $_SESSION["tmpFemale"] === "Female") {
            $DestinationFiles .= "../../../users/female/" . $_SESSION["User"] . "/profile/" . md5(time()) . $ImageName;
        } else if (isset($_SESSION["tmpMale"]) && $_SESSION["tmpMale"] === "Male") {
            $DestinationFiles .= "../../../users/male/" . $_SESSION["User"] . "/profile/" . md5(time()) . $ImageName;
        }

        $PostDataObject = new Control();
        $GetDataObject = new View();

        $GetProfileCount = $GetDataObject->CountRowProfiles($_SESSION["USER_ID"]);

        if ($GetProfileCount === 0) {

            $Result = $PostDataObject->SetProfile($_SESSION["USER_ID"], $DestinationFiles);

            if ($Result === true) {
                move_uploaded_file($ImageTemp, $DestinationFiles);
                $_SESSION["SqHash"] = TokenGenerate();
                $_SESSION["Second_Stage"] = 2;
                header("location: ../Step2/Securityquestions.php?Hash=" . $_SESSION["SqHash"]);
                exit();
            } else {
                $_SESSION["up_error"] = TokenGenerate();
                if (isset($_SESSION["tmpFemale"]) && $_SESSION["tmpFemale"] === "Female") {
                    $_SESSION["err_type"] = GenerateErrorToken();
                    header("location: ../Step1/Female.php?Token=" . $_SESSION["up_error"]);
                } else {
                    $_SESSION["err_type"] = TokenGenerate();
                    header("location: ../Step1/Male.php?Token=" . $_SESSION["up_error"]);
                }
            }
        } else {
            $_SESSION["SqHash"] = TokenGenerate();
            header("location: ../step2/Securityquestions.php?Hash=" . $_SESSION["SqHash"]);
            exit();
        }
    } else {
        if (isset($_SESSION["tmpFemale"]) && $_SESSION["tmpFemale"] === "Female") {
            $_SESSION["err_type"] = TokenGenerate();
            header("location: ../Step1/Female.php?Token=" . $_SESSION["err_type"]);
        } else {
            $_SESSION["err_type"] = TokenGenerate();
            header("location: ../Step1/Male.php?Token=" . $_SESSION["err_type"]);
        }
    }
}
