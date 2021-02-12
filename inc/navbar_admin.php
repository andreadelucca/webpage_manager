<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-admin" aria-controls="navbar-admin" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbar-admin">
        <ul class="navbar-nav">
            <li class="nav-item li-spaces">
                <a class="nav-link" href="index_admin.php">Início</a>
            </li>
            <li class="nav-item li-spaces dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown_users" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuários</a>
                <div class="dropdown-menu" aria-labelledby="dropdown10">
                    <a class="dropdown-item" href="new-user.php">Cadastrar Usuários</a>
                    <a class="dropdown-item" href="manage-users.php">Gerenciar Usuários</a>
                </div>
            </li>
            <li class="nav-item li-spaces dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown_public" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Publicações</a>
                <div class="dropdown-menu" aria-labelledby="dropdown10">
                    <a class="dropdown-item" href="new-publish.php">Realizar Publicação</a>
                    <a class="dropdown-item" href="manage-publishes.php">Analisar Publicações Realizadas</a>
                </div>
            </li>
            <li class="nav-item li-spaces">
                <a class="nav-link" href="#">Alterar Minha Senha</a>
            </li>
            <li class="nav-item li-spaces">
                <a class="nav-link" href="logout.php">Sair do Sistema</a>
            </li>
        </ul>
    </div>
</nav>
<br>
<div class="container-fluid">
    <div class="d-flex justify-content-center">
        <h6>
            <i>
                Logado como <?php echo $_SESSION['user_name']; ?>
            </i>
        </h6>
    </div>
</div>