<?php

include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

/*
 * Login Functions
 *
 * Functions to create login, authorize login, validate login or deactivate logins. These functions may change ;)
 */

function sendLoginRequest($username, $usersurname, $userlogin, $userpassword, $idprofile) {
    global $connection;

    $sqlString = "INSERT INTO ln_website.ln_users VALUES(null, '$username', '$usersurname', '$userlogin', '$userpassword', 'SOLICITADO','INATIVO', $idprofile)";
    $resultset = mysqli_query($connection, $sqlString) or die("Erro ao processar dados: " . mysqli_error($connection));

    return mysqli_insert_id($connection);
}


/*
 * Other functions
 *
 *
 */