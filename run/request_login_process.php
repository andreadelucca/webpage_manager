<?php

    include '../inc/config.php';
    include '../inc/main_functions.php';
    include '../inc/data_functions.php';

    # Variables for Data Controlling
    $errors = 0;
    $messageAlertError = '';
    $messageAlertSuccess = '';

    # Variables from POST request
    $username = $_POST['username'];
    $usersurname = $_POST['usersurname'];
    $userlogin = $_POST['userlogin'];
    $userpassword = $_POST['userpassword'];
    $userloginprofile = $_POST['userloginprofile'];

    # Encrypting password - For security reasons
    $options = array (
        "cost" => 10
    );
    $userPasswordHash = password_hash($userpassword, PASSWORD_DEFAULT, $options);

    # Form validation for null data or wrong options
    if(strlen($username) == 0 && strlen($usersurname) == 0 && strlen($userlogin) == 0 && strlen($userpassword) == 0 && $userloginprofile == 'undefined' || $userloginprofile == '') {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Todos os campos são obrigatórios. Preencha-os adequadamente!');
    } else if(strlen($username) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe o seu nome');
    } else if(strlen($usersurname) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe o seu sobrenome');
    } else if(strlen($userlogin) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe um nome de usuário');
    } else if(strlen($userpassword) == 0) {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Senha não pode estar vazia');
    } else if ($userloginprofile == 'undefined' || $userloginprofile == '') {
        $errors++;
        $messageAlertError = style_short_alerts('danger', 'Erro ao inserir dados!', 'Informe um nível de acesso a ser autorizado');
    }

    # Database processing form
    if ($errors == 0) {
        $newProfile = sendLoginRequest($username, $usersurname, $userlogin, $userPasswordHash, $userloginprofile);
        if($newProfile > 0) {

            $messageAlertSuccess = style_alerts('success','Enviado com Sucesso!', 'Aguarde até que um responsável administrador autorize seu acesso', 'Caso a demora seja maior que o previsto, entre em contato com o Suporte');
            $messageAlertError = '';

            $return['return_json'] = 1;
            $return['messageAlertSuccess'] = $messageAlertSuccess;
            $return['messageAlertError'] = $messageAlertError;
        } else {
            $return['return_json'] = 0;
            $return['messageAlertSuccess'] = '';

            $messageAlertError = style_alerts('danger', 'Erro ao informar dados', 'Houve um erro ao processar sua requisição dentro do sistema.', 'Contate o administrador do sistema ou entre em contato com o suporte para mais detalhes.');
            $return['messageAlertError'] = $messageAlertError;
        }
    } else {
        $return['return_json'] = 0;
        $return['messageAlertSuccess'] = '';
        $return['messageAlertError'] = $messageAlertError;
    }

    echo $processJSON = json_encode($return);
