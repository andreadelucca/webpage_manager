<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login-page.css">
    <title>Login | Webpage Manager v1</title>
</head>
<body class="text-center">
    <form class="form-signin">
        <img class="mb-4" src="/docs/4.6/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        <label for="inputEmail" class="sr-only">Nome de Usuário</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Nome de Usuário" required autofocus>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required>
        <div class="mb-3">
            <a href="#" style="font-size: small;" >Não tem login? Solicite acesso aqui</a>
        </div>
        <button class="btn btn-lg btn-success btn-block" type="submit">Acessar</button>
        <p class="mt-5 mb-3 text-muted" style="font-size: smaller;">&copy; <?php echo date('Y'); ?> - Webpage Manager v1. Open source project. See the code
            <a href="https://github.com/andreadelucca/lubnorte2" target="_blank">here</a>!</p>
    </form>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>