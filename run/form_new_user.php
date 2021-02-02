<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/inc/main_functions.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/inc/data_functions.php';

    # Variables for Data Controlling
    $errors = 0;
    $messageAlertError = '';
    $messageAlertSuccess = '';

    # Variables from POST request
    $username = $_POST['username'];
    $usersurname = $_POST['usersurname'];
    $userlogin = $_POST['userlogin'];
    $userpass = $_POST['userpass'];
    $userpass2 = $_POST['userpass2'];
    $useraccessprofile = $_POST['useraccessprofile'];

    # Encrypting password - For security reasons
    $options = array (
        "cost" => 10
    );
    $userPasswordHash = password_hash($userpass, PASSWORD_DEFAULT, $options);

    # Treating data - for error or success messages
    if (strlen($username) == 0 && strlen($usersurname) == 0 && strlen($userlogin) == 0 && strlen($userpass) == 0 && strlen($userpass2) == 0 && $useraccessprofile == 'undefined' && $useraccessprofile = '') {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Todos os campos são obrigatórios. Preencha-os adequadamente!');
        $messageAlertSuccess = '';
    } else if (strlen($username) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe o seu nome');
        $messageAlertSuccess = '';
    } else if (strlen($usersurname) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe o seu sobrenome');
        $messageAlertSuccess = '';
    } else if (strlen($userlogin) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe o seu login');
        $messageAlertSuccess = '';
    } else if (strlen($userpass) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'A senha é obrigatória');
        $messageAlertSuccess = '';
    } else if (strlen($userpass2) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'A repetição da senha é obrigatória');
        $messageAlertSuccess = '';
    } else if ($userpass != $userpass2) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'As senhas não coincidem');
        $messageAlertSuccess = '';
    } else if ($useraccessprofile == 'undefined' || $useraccessprofile = '') {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Um perfil de acesso deve ser informado');
        $messageAlertSuccess = '';
    }

    if ($errors == 0) {

        # Yeah. Fuck it all! The $_POST data was validated and is right. I'll be back here, i promise ;)
        $submitRequest = newLoginUser($username, $usersurname, $userlogin, $userPasswordHash, $_POST['useraccessprofile']);
        if ($submitRequest > 0) {

            $messageAlertSuccess = style_short_alerts('success', 'Informações salvas com sucesso!', 'O usuário está ativo e pode logar normalmente no sistema.');
            $messageAlertError = '';

            $return['return_json'] = 1;
            $return['messageAlertSuccess'] = $messageAlertSuccess;
            $return['messageAlertError'] = $messageAlertError;
        } else {
            $return['return_json'] = 0;
            $return['messageAlertSuccess'] = '';

            $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Houve um erro ao processar sua requisição dentro do sistema. Contate o administrador e tente novamente.');
            $return['messageAlertError'] = $messageAlertError;
        }
    } else {
        $return['return_json'] = 0;
        $return['messageAlertSuccess'] = '';
        $return['messageAlertError'] = $messageAlertError;
    }

    echo $processJSON = json_encode($return);