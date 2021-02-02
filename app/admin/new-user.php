<?php
# --------------------------------------- Configs for index_admin file ---------------------------------------------
define('DEBUG', false);

set_time_limit(0);
ini_set('post_max_size', '600M');
ini_set('upload_max_filesize', '600M');

if(DEBUG == true) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL & ~E_NOTICE);
} else {
    ini_set('display_errors', 'Off');
    error_reporting(0);
}
date_default_timezone_set('America/Manaus');

# ------------------------------------------------ End of configs --------------------------------------------------

include $_SERVER['DOCUMENT_ROOT'] . "/inc/config.php";
global $pageTitle;
global $githubLink;

session_start();

if ((!isset($_SESSION['user_login']) == true) && (!isset($_SESSION['desc_profile']) == true) && ($_SESSION['desc_profile'] != 'Administrador')) {
    unset($_SESSION['user_login']);
    unset($_SESSION['desc_profile']);
    header("location: ../../login.php");
} else {
    $navbarSystem = $_SESSION['navbar_name'];
}

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/project-customcss.css">
    <title>Novo Usuário | <?php echo $pageTitle; ?></title>
</head>
<body class="font-structure">

    <?php include "../../inc/" . $navbarSystem; ?>

    <div class="container">

        <br>

        <div class="row">

            <div class="col-md-5">
                <div class="jumbotron">
                    <h1 class="display-4">Novo Usuário</h1>
                    <p class="lead text-justify">Preencha adequadamente todos os campos, conforme se pede. </p>
                    <hr class="my-4">
                    <p class="text-justify">Os campos com * são de caráter obrigatório</p>
                    <p class="text-justify"><i>Caso esteja usando navegador Chrome, o navegador irá sugerir uma senha para você (Recomendado)</i></p>
                </div>
            </div>

            <div class="col-md-7">
                <div id="message-error-success">

                </div>
                <hr class="my-4">
                <form id="newuser-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Nome *</label>
                            <input type="text" class="form-control" id="username_new" placeholder="Nome da pessoa (ex.: André de Paula)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usersurname">Sobrenome *</label>
                            <input type="text" class="form-control" id="usersurname_new" placeholder="Sobrenome da pessoa (ex.: Bentes)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="userlogin">Login *</label>
                        <input type="text" class="form-control" id="userlogin_new" placeholder="Informe seu nome de usuário (ex.: marcelo.sobral)" autocomplete="username">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="userpass_1">Senha *</label>
                                <input type="password" class="form-control" id="userpass_new" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="userpass_2">Repita a Senha *</label>
                                <input type="password" class="form-control" id="userpass_2_new" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="useraccess_profile">Perfil de Acesso *</label>
                            <select id="useraccess_profile_new" class="form-control">
                                <option selected value="undefined">Escolha um perfil</option>
                                <option value="1">Administrador</option>
                                <option value="2">Usuário</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success" onclick="submitFormUser();">Salvar Dados</button>&nbsp;
                        <button type="submit" class="btn btn-warning" onclick="resetForm();">Limpar Formulário</button>&nbsp;
                        <button type="submit" class="btn btn-danger" onclick="window.history.go(-1); return false;">Voltar a página anterior</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <footer class="d-flex justify-content-center">
        <p class="mt-5 mb-3 text-muted" style="font-size: smaller;">&copy; <?php echo date('Y'); ?> - Webpage Manager
            v1. Open source project. See the code
            <a href="<?php echo $githubLink; ?>" target="_blank">here</a>!</p>
    </footer>

    <script src="../../assets/js/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>

    <script>

        const resetForm = () => {
            document.getElementById("newuser-form").reset();
        }

        const submitFormUser = () => {

        }

    </script>
</body>
</html>
