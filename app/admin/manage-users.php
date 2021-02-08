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
include $_SERVER['DOCUMENT_ROOT'] . "/inc/data_functions.php";
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
    <link rel="stylesheet" href="../../assets/css/highcharts_datastyles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <title>Gerenciar Usuários | <?php echo $pageTitle; ?></title>

</head>
<body class="font-structure">

    <!-- Modal Section -->
    <div class="modal fade" id="modalUpdateUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Detalhes do Usuário</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Preencha os campos para continuar. Para sair da janela, toque no ícone "x"</h6>
                    <br>
                    <form id="formUserDataUpdate">
                        <input class="form-control" type="hidden" name="valueIduser" id="valueIduser">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="valueUsername">Nome *</label>
                                <input type="text" class="form-control" id="valueUsername">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="valueUsersurname">Sobrenome *</label>
                                <input type="text" class="form-control" id="valueUsersurname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="valueUserlogin">Login *</label>
                            <input type="text" class="form-control" id="valueUserlogin" autocomplete="username">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label for="valueUserpass">Senha *</label>
                                    <input type="password" class="form-control" id="valueUserpass" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label for="valueUserpass2">Repita a Senha *</label>
                                    <input type="password" class="form-control" id="valueUserpass2" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="valueUserAccessProfile">Perfil de Acesso *</label>
                                <select id="valueUserAccessProfile" class="form-control">
                                    <option value="0" selected>Escolha um perfil</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Usuário</option>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-success" id="buttonSubmitForm" onclick="updateUserInfo();">Salvar Dados</button>&nbsp;
                            <button type="button" class="btn btn-warning" id="buttonClearForm" onclick="resetFormulary();">Limpar Formulário</button>
                        </div>
                    </form>
                </div>
                <div class="div_message_return">

                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal -->

    <?php include "../../inc/" . $navbarSystem; ?>
    <br>

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Usuários</h1>
            <p class="lead text-justify">Aqui estão registrados todos os usuários dentro do sistema, autorizados, não-autorizados, pendentes de autorização, etc. Sinta-se livre para modificar, autorizar e revogar acessos de usuários no sistema</p>
            <hr class="my-4">
            <p class="text-justify">Selecione um dos registros na tabela abaixo e escolha o que fazer</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="message-management-users">

                </div>
            </div>
            <div class="col-md-12">
                <?php echo listAllActiveUsers(); ?>
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
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

    <script>

        // -------------------------------------------- Dropdown Code --------------------------------------------------

        $('.dropdown-toggle').dropdown();

        // -------------------------------------------- Datatables Script ----------------------------------------------

        $(document).ready( function () {
            $('#table-list-users').DataTable({
                "oLanguage": {
                    "sProcessing":   "Processando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "Não foram encontrados resultados",
                    "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                    "sInfoFiltered": "",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Seguinte",
                        "sLast":     "Último"
                    }
                }
            });
        } );

        // -------------------------------------- JavaScript Main Functions --------------------------------------------

        const callDataModal = (idUser) => {
            $('#formDataUser').trigger("reset");

            $('#modalUpdateUser').modal("show");
            let runScript = '../../run/manage_updates_user.php';
            let form_data = new FormData();

            form_data.append('idUser', idUser);
            form_data.append('message', 'LIST_USER');

            $.ajax({
                url: runScript,
                data: form_data,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    let contentData = JSON.parse(data);
                    if(contentData.return === 1) {
                        $('#valueIduser').val(contentData.idusers);
                        $('#valueUsername').val(contentData.username);
                        $('#valueUsersurname').val(contentData.usersurname);
                        $('#valueUserlogin').val(contentData.userlogin);
                        $('#valueUserpass').val(contentData.userpass);
                        $('#valueUserpass2').val(contentData.userpass);
                        $('#valueUserAccessProfile').val(contentData.iduserprofile);
                    } else {
                        $('#div_message_return').html(contentData.messageError);
                    }
                }
            })
        }

        const activateUser = (idUser) => {
            $.post('../../run/manage_updates_user.php', {
                idUser: idUser,
                message: 'ACTIVATE_USER'
            }, function(data) {
                console.log(data);
                let values = JSON.parse(data);
                if(values.return === 1) {
                    $('#message-management-users').html(values.messageSuccess);
                    setTimeout(function(){
                        location.reload();
                    }, 4000);
                } else {
                    $('#message-management-users').html(values.messageError);
                }
            });
        }

        const deactivateUser = (idUser) => {
            $.post('../../run/manage_updates_user.php', {
                idUser: idUser,
                message: 'DEACTIVATE_USER'
            }, function(data) {
                console.log(data);
                let values = JSON.parse(data);
                if(values.return === 1) {
                    $('#message-management-users').html(values.messageSuccess);
                    setTimeout(function(){
                        location.reload();
                    }, 4000);
                } else {
                    $('#message-management-users').html(values.messageError);
                }
            });
        }

        const authorizeUser = (idUser) => {
            $.post('../../run/manage_updates_user.php', {
                idUser: idUser,
                message: 'AUTHORIZE_USER'
            }, function(data) {
                console.log(data);
                let values = JSON.parse(data);
                if(values.return === 1) {
                    $('#message-management-users').html(values.messageSuccess);
                    setTimeout(function(){
                        location.reload();
                    }, 4000);
                } else {
                    $('#message-management-users').html(values.messageError);
                }
            });
        }

        const unauthorizeUser = (idUser) => {
            $.post('../../run/manage_updates_user.php', {
                idUser: idUser,
                message: 'UNAUTHORIZE_USER'
            }, function(data) {
                console.log(data);
                let values = JSON.parse(data);
                if(values.return === 1) {
                    $('#message-management-users').html(values.messageSuccess);
                    setTimeout(function(){
                        location.reload();
                    }, 4000);
                } else {
                    $('#message-management-users').html(values.messageError);
                }
            });
        }

        const updateUserInfo = () => {
            let userid = $('#valueIduser').val();
            let username = $('#valueUsername').val();
            let usersurname = $('#valueUsersurname').val();
            let userlogin = $('#valueUserlogin').val();
            let userpassword = btoa($('#valueUserpass').val());
            let userpassword2 = btoa($('#valueUserpass2').val());
            let useraccessprofile = $('#valueUserAccessProfile').val();

            let processFile = '../../run/manage_updates_user.php';

            let form_data = new FormData();
            form_data.append('userid', userid);
            form_data.append('username', username);
            form_data.append('usersurname', usersurname);
            form_data.append('userlogin', userlogin);
            form_data.append('userpassword', userpassword);
            form_data.append('userpassword2', userpassword2);
            form_data.append('useraccessprofile', useraccessprofile);
            form_data.append('message', 'SAVE_USER');

            $.ajax({
                url: processFile,
                data: form_data,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    let values = JSON.parse(data);
                    if (values.return === 1) {
                        $('#div_message_return').html(values.message);
                        location.reload();
                    } else {
                        $('#div_message_return').html(values.message);
                    }
                }
            });
        }

        const resetFormulary = () => {
            document.getElementById("formUserDataUpdate").reset();
        }

    </script>
</body>
</html>
