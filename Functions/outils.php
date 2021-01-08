<?php

/**
 * get_user_by_username
 *
 * @param  string $username
 * @param  PDO $db
 * @return array|bool
 */
function get_user_by_username($username, $db) {
    global $DB_PREFIX;
    $req = $db->prepare("SELECT * FROM ${DB_PREFIX}utilisateurs WHERE username = ?;");
    $req->execute(array($username));
    if ($user = $req->fetch()) {
        return $user;
    } else {
        return false;
    }
}

/**
 * get_user_by_username
 *
 * @param  string $username
 * @param  PDO $db
 * @return int|bool
 */
function get_userID_by_username($username, $db) {
    return get_user_by_username($username, $db)['ID'];
}
