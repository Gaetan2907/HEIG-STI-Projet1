<?php

public function hash_password($pwd) {
    return password_hash($pwd, PASSWORD_BCRYPT);
}
