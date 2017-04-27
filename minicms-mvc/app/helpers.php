<?php

function logout()
{
    unset($_SESSION["minicms_mvc_auth"]);
    Messages::addSuccess("you are now logged out");
    redirect();
    exit;
}


function redirect($controller = "", $action = null, $params = [])
{
    if (isset($action) === true) {
        $params["a"] = $action;
    }

    $params["c"] = $controller;

    if ($controller !== "") {
        $strParams = "?";
        foreach ($params as $key => $value) {
            $strParams .= "$key=$value&";
        }
    }

    Messages::saveForLater();
    header("Location: index.php".rtrim($strParams, "&"));
    exit;
}


function loadView($bodyView, $pageTitle, $vars = [])
{
    global $user;
    $headView = "";
    foreach ($vars as $varName => $value) {
        ${$varName} = $value;
    }
    require_once "../views/layout.php";
}


function isLoggedIn()
{
    return ($user !== false);
}


function checkPatterns($patterns, $subject)
{
    if (is_array($patterns) === false) {
        $patterns = [$patterns];
    }

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $subject) == false) {
// keep loose comparison !
// preg_match() returns 0 if pattern isn't found, or false on error
            return false;
        }
    }

    return true;
}

function checkNameFormat($name)
{
    $namePattern = "[a-zA-Z0-9_-]{4,}";
    if (checkPatterns("/$namePattern/", $name) === false) {
        return "The user name has the wrong format. Minimum four letters, numbers, hyphens or underscores.";
    }
    return "";
}


function checkEmailFormat($email)
{
    $emailPattern = "^[a-zA-Z0-9_\.-]{1,}@[a-zA-Z0-9-_\.]{4,}$";
    if (checkPatterns("/$emailPattern/", $email) === false) {
        Message::addError("The email has the wrong format");
        return false;
    }
    return true;
}


function checkPasswordFormat($password, $passwordConfirm)
{
    $ok = true;
    $patterns = ["/[A-Z]+/", "/[a-z]+/", "/[0-9]+/"];
    $minPasswordLength = 3;

    if (checkPatterns($patterns, $password) === false || strlen($password) < $minPasswordLength) {
        Messages::addError("The password must be at least $minPasswordLength characters long and have at least one lowercase letter, one uppercase letter and one number.");
        $ok = false;
    }

    if (isset($passwordConfirm) === true && $password !== $passwordConfirm) {
        Messages::addError("The password confirmation does not match the password.");
        $ok = false;
    }

    return $ok;
}
