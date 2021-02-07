<?php

include '../inc/config.php';
include '../inc/main_functions.php';

$idUser = $_POST['idUser'];
$message = $_POST['message'];

function activateUser($idUserpost){
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

    if($errors == 0) {
        if($numRows > 0) {
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

function deactivateUser($idUserpost){
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

    if($errors == 0) {
        if($numRows > 0) {
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

function authorizeUser($idUserpost){
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

    if($errors == 0) {
        if($numRows > 0) {
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

function unauthorizeUser($idUserpost){
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

    if($errors == 0) {
        if($numRows > 0) {
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

if($message == 'ACTIVATE_USER') {
    activateUser($idUser);
} else if ($message == 'DEACTIVATE_USER') {
    deactivateUser($idUser);
} else if ($message == 'AUTHORIZE_USER') {
    authorizeUser($idUser);
} else if ($message == 'UNAUTHORIZE_USER') {
    unauthorizeUser($idUser);
}