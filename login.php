<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
    global $pageTitle;
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login-page.css">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
    <title>Login | <?php echo $pageTitle; ?></title>
</head>
<body>
<div class="container">
    <h1 class="display-4">Acesso aos Sistemas</h1>
    <hr class="my-4">
    <h4 style="font-weight: 200; line-height: 1.2;">Antes de continuar, faça o login</h4>
    <br>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Nome de Usuário</label>
                <input type="text" class="form-control" id="user_name" required>
            </div>
            <div class="form-group col-md-6">
                <label for="usersurname">Senha de Acesso</label>
                <input type="password" class="form-control" id="user_surname" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12 d-flex justify-content-center">
                <div class="mb-3">
                    <a href="request_login.php" style="font-size: small;">Não tem login? Solicite acesso aqui</a>
                </div>
            </div>
            <div class="form-group col-md-12 d-flex justify-content-center">
                <button type="submit" id="sendLoginData" class="btn btn-success">Acessar</button>
            </div>
        </div>
    </form>
    <footer class="d-flex justify-content-center">
        <p class="mt-5 mb-3 text-muted" style="font-size: smaller;">&copy; <?php echo date('Y'); ?> - Webpage Manager
            v1. Open source project. See the code
            <a href="https://github.com/andreadelucca/lubnorte2" target="_blank">here</a>!</p>
    </footer>
</div>

<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>