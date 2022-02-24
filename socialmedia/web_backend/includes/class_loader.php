<?php
spl_autoload_register("loadclasses");

function loadclasses($classes)
{
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (strpos($url, "includes") !== false) {
        $path = "../classes/";
    } else if (strpos($url, "Step1")) {
        $path = "../../classes/";
    } else if (strpos($url, "steps_backend")) {
        $path = "../../classes/";
    } else if (strpos($url, "Step2")) {
        $path = "../../classes/";
    } else if (strpos($url, "Feed")) {
        $path = "../classes/";
    } else {
        $path = "classes/";
    }

    $ext = ".class.php";
    require $path . $classes . $ext;
}
