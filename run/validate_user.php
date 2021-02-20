<?php

include "../inc/config.php";
include "../inc/main_functions.php";

global $connection;

$userlogin    = $_POST['username'];
$userpassword = base64_decode($_POST['userpassword']);
$return       = 0;
$error        = 0;
$message      = '';

# Decryption settings
$options = array (
    "cost" => 10
);

# ---------------------------------------- Procedure to validate Login -------------------------------------------------

if (!$userlogin) {
    $error++;
    $message = style_short_alerts('danger', 'Erro ao realizar login.', 'Usuário não informado.');
} else {
    if (!$userpassword) {
        $error++;
        $message = style_short_alerts('danger', 'Erro ao realizar login.', 'Senha não informada.');
    } else {
        $sqlQuery = "    
            select * from ln_users, ln_userprofile
            where id_profile = id_userprofile 
            and request_status = 'APROVADO'
            and status_user = 'ATIVO'
            and user_login = '$userlogin'
        ";
        $resultset = mysqli_query($connection, $sqlQuery) or die("Erro ao realizar requisição do banco de dados: " . $sqlQuery . " / " . mysqli_error($connection));
        $returnQuery = mysqli_num_rows($resultset);
        if($returnQuery == 0) {
            $error++;
            $message = style_short_alerts('danger', 'Erro ao realizar login.', 'Usuário ou senha inválidos. Tente novamente.');
        } else {
            if ($data = mysqli_fetch_assoc($resultset)) {
                if(password_verify($userpassword, $data['user_pass'])) {
                    $id_user        = $data['id_users'];
                    $user_name      = $data['user_name'];
                    $user_surname   = $data['user_surname'];
                    $user_login     = $data['user_login'];
                    $status_user    = $data['status_user'];
                    $id_profile     = $data['id_profile'];
                    $id_userprofile = $data['id_userprofile'];
                    $desc_profile   = $data['desc_profile'];
                    $home_path      = $data['home_path'];
                    $profile_path   = $data['profile_path'];
                    $navbar_name    = $data['navbar_name'];

                    session_start();

                    $_SESSION['id_user']      = $id_user;
                    $_SESSION['user_name']    = $user_name;
                    $_SESSION['user_surname'] = $user_surname;
                    $_SESSION['user_login']   = $user_login;
                    $_SESSION['status_user']  = $status_user;
                    $_SESSION['desc_profile'] = $desc_profile;
                    $_SESSION['home_path']    = $home_path;
                    $_SESSION['profile_path'] = $profile_path;
                    $_SESSION['navbar_name']  = $navbar_name;

                    $return = 1;
                    $message = style_short_alerts('success', 'Login Autorizado!', 'Aguarde. Estamos redirecionando você para a página principal.');
                } else {
                    $return = 0;
                    $message = style_short_alerts('danger', 'Erro ao realizar login.', 'Senha inválida.');
                }
            } else {
                $return = 0;
                $message = style_short_alerts('danger', 'Erro ao realizar login.', 'Ocorreu um erro ao verificar seu login. Consulte o administrador do sistema para mais detalhes.');
            }
        }
    }
}

$returnJSON['return_json']  = $return;
$returnJSON['message']      = $message;
$returnJSON['homepath']     = $home_path;
$returnJSON['navbarName']   = $navbar_name;
$returnJSON['url']          = 'app/'. $profile_path . '/' . $home_path;
$returnJSON['sql'] = $sqlQuery;

echo $requestReturn = json_encode($returnJSON);