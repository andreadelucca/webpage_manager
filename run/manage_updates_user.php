<?php

include '../inc/config.php';
include '../inc/main_functions.php';

$idUser = $_POST['idUser'];
$message = $_POST['message'];

function activateUser($idUserpost)
{
    global $connection;

    $errors = 0;
    $message = '';

    if ($idUserpost == '') {
        $errors++;
        $message = style_short_alerts('danger', 'Erro ao atualizar informações!', 'O sistema não pode processar a informação. ID de Usuário não especificado');
    }

    $sqlQuery = "update ln_website.ln_users set status_user = 'ATIVO' where id_users = $idUserpost";
    $resultset = mysqli_query($connection, $sqlQuery);
    $numRows = mysqli_affected_rows($connection);

    if ($errors == 0) {
        if ($numRows > 0) {
            $returnJSON['return'] = 1;
            $returnJSON['messageSuccess'] = style_short_alerts('success', 'Informações atualizadas com sucesso!', 'Usuário ativo no sistema! Aguarde enquanto recarregamos a página');
            $returnJSON['messageError'] = '';
        } else {
            $returnJSON['return'] = 0;
            $returnJSON['messageSuccess'] = '';
            $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar informações', 'Verifique as informações e em caso de persistencia do erro, contate o administrador');

        }
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = $message;
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function deactivateUser($idUserpost)
{
    global $connection;

    $errors = 0;
    $message = '';

    if ($idUserpost == '') {
        $errors++;
        $message = style_short_alerts('danger', 'Erro ao atualizar informações!', 'O sistema não pode processar a informação. ID de Usuário não especificado');
    }

    $sqlQuery = "update ln_website.ln_users set status_user = 'INATIVO' where id_users = $idUserpost";
    $resultset = mysqli_query($connection, $sqlQuery);
    $numRows = mysqli_affected_rows($connection);

    if ($errors == 0) {
        if ($numRows > 0) {
            $returnJSON['return'] = 1;
            $returnJSON['messageSuccess'] = style_short_alerts('success', 'Informações atualizadas com sucesso!', 'Usuário desativado no sistema! Aguarde enquanto recarregamos a página');
            $returnJSON['messageError'] = '';
        } else {
            $returnJSON['return'] = 0;
            $returnJSON['messageSuccess'] = '';
            $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar informações', 'Verifique as informações e em caso de persistencia do erro, contate o administrador');

        }
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = $message;
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function authorizeUser($idUserpost)
{
    global $connection;

    $errors = 0;
    $message = '';

    if ($idUserpost == '') {
        $errors++;
        $message = style_short_alerts('danger', 'Erro ao atualizar informações!', 'O sistema não pode processar a informação. ID de Usuário não especificado');
    }

    $sqlQuery = "update ln_website.ln_users set request_status = 'APROVADO' where id_users = $idUserpost";
    $resultset = mysqli_query($connection, $sqlQuery);
    $numRows = mysqli_affected_rows($connection);

    if ($errors == 0) {
        if ($numRows > 0) {
            $returnJSON['return'] = 1;
            $returnJSON['messageSuccess'] = style_short_alerts('success', 'Informações atualizadas com sucesso!', 'Usuário aprovado no sistema! Agora, o usuario tem permissão para realizar login. Aguarde enquanto recarregamos a página');
            $returnJSON['messageError'] = '';
        } else {
            $returnJSON['return'] = 0;
            $returnJSON['messageSuccess'] = '';
            $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar informações', 'Verifique as informações e em caso de persistencia do erro, contate o administrador');

        }
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = $message;
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function unauthorizeUser($idUserpost)
{
    global $connection;

    $errors = 0;
    $message = '';

    if ($idUserpost == '') {
        $errors++;
        $message = style_short_alerts('danger', 'Erro ao atualizar informações!', 'O sistema não pode processar a informação. ID de Usuário não especificado');
    }

    $sqlQuery = "update ln_website.ln_users set request_status = 'REPROVADO' where id_users = $idUserpost";
    $resultset = mysqli_query($connection, $sqlQuery);
    $numRows = mysqli_affected_rows($connection);

    if ($errors == 0) {
        if ($numRows > 0) {
            $returnJSON['return'] = 1;
            $returnJSON['messageSuccess'] = style_short_alerts('success', 'Informações atualizadas com sucesso!', 'Usuário recusado no sistema! O usuário não poderá mais realizar login. Aguarde enquanto recarregamos a página');
            $returnJSON['messageError'] = '';
        } else {
            $returnJSON['return'] = 0;
            $returnJSON['messageSuccess'] = '';
            $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar informações', 'Verifique as informações e em caso de persistencia do erro, contate o administrador');

        }
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = $message;
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function loadUser($idUserpost)
{
    global $connection;

    $sqlQuery = "SELECT * FROM ln_website.ln_users, ln_website.ln_userprofile WHERE id_userprofile = id_profile AND id_users = $idUserpost";
    $resultset = mysqli_query($connection, $sqlQuery);
    $numRows = mysqli_num_rows($resultset);

    if ($numRows > 0) {
        $return = 1;
        while ($data = mysqli_fetch_array($resultset)) {
            $idusers = $data['id_users'];
            $username = $data['user_name'];
            $usersurname = $data['user_surname'];
            $userlogin = $data['user_login'];
            $userpass = $data['user_pass'];
            $requeststatus = $data['request_status'];
            $statususer = $data['status_user'];
            $idprofile = $data['id_profile'];
            $iduserprofile = $data['id_userprofile'];
            $descprofile = $data['desc_profile'];
            $homepath = $data['home_path'];
            $profilepath = $data['profile_path'];
            $navbarname = $data['navbar_name'];

        }
    } else {
        $return = 0;
        $messageSuccess = '';
        $messageError = style_short_alerts('danger', 'Erro ao consultar os dados!', 'Houve um erro ao carregar os dados. Tente novamente');
    }

    $returnJSON['return'] = $return;
    $returnJSON['messageSuccess'] = $messageSuccess;
    $returnJSON['messageError'] = $messageError;
    $returnJSON['idusers'] = $idusers;
    $returnJSON['username'] = $username;
    $returnJSON['usersurname'] = $usersurname;
    $returnJSON['userlogin'] = $userlogin;
    $returnJSON['userpass'] = substr($userpass, 0, 12);
    $returnJSON['requeststatus'] = $requeststatus;
    $returnJSON['statususer'] = $statususer;
    $returnJSON['idprofile'] = $idprofile;
    $returnJSON['iduserprofile'] = $iduserprofile;
    $returnJSON['descprofile'] = $descprofile;
    $returnJSON['homepath'] = $homepath;
    $returnJSON['profilepath'] = $profilepath;
    $returnJSON['navbarname'] = $navbarname;

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function saveUpdatedUser() {
    global $connection;


}

/*
 * Main methods - to load many functions in a single file
 */

if ($message == 'ACTIVATE_USER') {
    activateUser($idUser);
} else if ($message == 'DEACTIVATE_USER') {
    deactivateUser($idUser);
} else if ($message == 'AUTHORIZE_USER') {
    authorizeUser($idUser);
} else if ($message == 'UNAUTHORIZE_USER') {
    unauthorizeUser($idUser);
} else if ($message == 'LIST_USER') {
    loadUser($idUser);
} else if ($message == 'SAVE_USER') {
    saveUpdatedUser();
}