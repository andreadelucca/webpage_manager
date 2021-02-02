<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php'; global $githubLink; global $pageTitle; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Requisitar Acesso aos Sistemas | <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login-page.css">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
</head>
<body>

<div class="container">
    <!-- Message of success or error -->
    <div id="message-success-error">

    </div>

    <h1 class="display-4">Requisitar Acesso aos Sistemas</h1>
    <hr class="my-4">
    <h4 style="font-weight: 200; line-height: 1.2;">Preencha todos os campos para solicitar acesso aos sistemas
        internos</h4>
    <br>
    <form id="requestLogin-form">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Nome</label>
                <input type="text" class="form-control" id="user_name">
            </div>
            <div class="form-group col-md-6">
                <label for="usersurname">Sobrenome</label>
                <input type="text" class="form-control" id="user_surname">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="userlogin">Usuário para acesso aos sistemas</label>
                <input type="text" class="form-control" id="user_login">
            </div>
            <div class="form-group col-md-4">
                <label for="userpassword">Senha de Acesso</label>
                <input type="password" class="form-control" id="user_password">
            </div>
            <div class="form-group col-md-4">
                <label for="userloginprofile">Perfil de Usuário</label>
                <select id="user_loginProfile" class="form-control">
                    <option value="undefined" selected>Escolha o perfil</option>
                    <option value="1">Administrador</option>
                    <option value="2">Usuário</option>
                </select>
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="form-group col-md-12 d-flex justify-content-center">
                <button type="button" id="sendRequestLoginFormData" class="btn btn-success" onclick="sendData();">Enviar
                    Solicitação
                </button> &nbsp;&nbsp;
                <a href="login.php" class="btn btn-warning">Voltar para Login</a>
            </div>
        </div>
    </form>

    <footer class="d-flex justify-content-center">
        <p class="mt-5 mb-3 text-muted" style="font-size: smaller;">&copy; <?php echo date('Y'); ?> - Webpage Manager
            v1. Open source project. See the code
            <a href="<?php echo $githubLink; ?>" target="_blank">here</a>!</p>
    </footer>

</div>

<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script>

    const sendData = () => {
        let username = $('#user_name').val();
        let usersurname = $('#user_surname').val();
        let userlogin = $('#user_login').val();
        let userpassword = $('#user_password').val();
        let userloginprofile = $('#user_loginProfile').val();

        let file_base = 'run/request_login_process.php';

        let form_data = new FormData();
        form_data.append('username', username);
        form_data.append('usersurname', usersurname);
        form_data.append('userlogin', userlogin);
        form_data.append('userpassword', userpassword);
        form_data.append('userloginprofile', userloginprofile);

        $.ajax({
            url: file_base,
            data: form_data,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (form_data) {
                let data = JSON.parse(form_data);
                let return_json = data.return_json;
                if (return_json == 1) {
                    $('#message-success-error').html(data.messageAlertSuccess);
                    $('#requestLogin-form').trigger("reset");

                } else {
                    $('#message-success-error').html(data.messageAlertError);
                }
            },
            fail: function () {
                $('#message-success-error').html(
                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">\n' +
                    '<h4 class="alert-heading">Ooops...</h4>\n' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '<p>A solicitação não pode ser atendida no momento. Pode ser devido a um problema de rede ou de configuração no sistema. Ou no envio dos dados.</p>\n' +
                    '<hr>\n' +
                    '<p class="mb-0">Caso o erro persista, mande uma mensagem para o desenvolvedor <a href="mailto:andrelucas.batista@outlook.com">aqui</a>.</p>\n' +
                    '</div>'
                );
            }
        });
    }

</script>
</body>
</html>