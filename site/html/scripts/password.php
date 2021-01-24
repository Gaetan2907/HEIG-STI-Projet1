<?php

// check if a password contains at least a number, capital characters
// and have a size bigger than 8
function checkPassword($pwd) {
    return strlen($pwd) >= 8 &&
        preg_match("#[0-9]+#", $pwd) &&
        preg_match("#[a-zA-Z]+#", $pwd);

    if (strlen($pwd) < 8) {
        $errors[] = "Password too short!";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "Password must include at least one number!";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "Password must include at least one letter!";
    }

    return ($errors == $errors_init);
}

function hash_password($pwd) {
    return password_hash($pwd, PASSWORD_BCRYPT);
}
