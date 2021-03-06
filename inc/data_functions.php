<?php
session_start();
include '../inc/config.php';
$userLoggedin = $_SESSION['id_user'];

function sendLoginRequest($username, $usersurname, $userlogin, $userpassword, $idprofile) {
    global $connection;

    $sqlString = "INSERT INTO ln_website.ln_users VALUES(null, '$username', '$usersurname', '$userlogin', '$userpassword', 'SOLICITADO','INATIVO', $idprofile)";
    $resultset = mysqli_query($connection, $sqlString) or die("Error while processing data: " . mysqli_error($connection));

    return mysqli_insert_id($connection);
}

function newLoginUser($username, $usersurname, $userlogin, $userpassword, $idprofile) {
    global $connection;

    $sqlString = "INSERT INTO ln_website.ln_users VALUES(null, '$username', '$usersurname', '$userlogin', '$userpassword', 'APROVADO','ATIVO', $idprofile);";
    $resultset = mysqli_query($connection, $sqlString) or die("Error while processing data: " . mysqli_error($connection));

    return mysqli_insert_id($connection);
}

function listAllActiveUsers() {
    global $connection;
    global $userLoggedin;
    $tableData = '';

    if(!$userLoggedin) {
        $userLogged = "";
    } else {
        $userLogged = "AND id_users NOT IN ($userLoggedin)";
    }

    $sqlQuery = "select * from ln_users, ln_userprofile where id_profile = id_userprofile $userLogged AND user_login != 'admin';";
    $resultset = mysqli_query($connection, $sqlQuery) or die("Error while processing data: " . mysqli_error());
    $rowCount = mysqli_num_rows($resultset);

    if($rowCount > 0) {
        while ($dataList = mysqli_fetch_array($resultset)) {
            $idUsers = $dataList['id_users'];
            $userName = $dataList['user_name'];
            $userSurname = $dataList['user_surname'];
            $userLogin = $dataList['user_login'];
            $userPass = $dataList['user_pass'];
            $requestStatus = $dataList['request_status'];
            $statusUser = $dataList['status_user'];
            $idProfile = $dataList['id_profile'];
            $idUserProfile = $dataList['id_userprofile'];
            $descProfile = $dataList['desc_profile'];
            $homePath = $dataList['home_path'];
            $profilePath = $dataList['profile_path'];
            $navbarName = $dataList['navbar_name'];

            if($statusUser == 'ATIVO') {
                $btnOptionAccess = '<a class="dropdown-item" href="javascript:void(0)" onclick="deactivateUser(' . $idUsers . ');">Desativar Usuário</a>';
            } else {
                $btnOptionAccess = '<a class="dropdown-item" href="javascript:void(0)" onclick="activateUser(' . $idUsers . ');">Ativar Usuário</a>';
            }

            if($requestStatus == 'SOLICITADO') {
                $btnUpdatePermissions = '<a class="dropdown-item" href="javascript:void(0)" onclick="authorizeUser(' . $idUsers . ');">Autorizar Usuário</a>';
            } else {
                $btnUpdatePermissions = '<a class="dropdown-item" href="javascript:void(0)" onclick="unauthorizeUser(' . $idUsers . ');">Desautorizar Usuário</a>';
            }

            $tableLine = '
                <tr>
                    <th scope="row">' . $idUsers . '</th>
                    <td>' . $userName . '</td>
                    <td>' . $userSurname . '</td>
                    <td>' . $userLogin . '</td>
                    <td>' . $requestStatus . '</td>
                    <td>' . $statusUser . '</td>
                    <td>' . $descProfile . '</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opções
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="callDataModal(' . $idUsers . ');">Atualizar Dados</a>
                                ' . $btnOptionAccess . '
                                ' . $btnUpdatePermissions . '
                            </div>
                        </div>
                    </td>
                </tr>
            ';

            $tableData = $tableData . $tableLine;

            $table = '
                <table class="table table-striped table-bordered table-responsive-xl nowrap" id="table-list-users" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">Login</th>
                            <th scope="col">Status Acesso</th>
                            <th scope="col">Status Usuário</th>
                            <th scope="col">Perfil de Acesso</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $tableData . '
                    </tbody>
                </table>
            ';
        }
    } else {
        return $table = "
            <table class='table table-striped table-bordered table-responsive-xl nowrap' id='table-list-users' style='width: 100%;'>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Nome de Usuário</th>
                            <th scope='col'>Sobrenome</th>
                            <th scope='col'>Login de Acesso</th>
                            <th scope='col'>Status de Acesso</th>
                            <th scope='col'>Status de Usuário</th>
                            <th scope='col'>Perfil de Acesso</th>
                            <th scope='col'>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
        ";
    }

    return $table;
}

function listAllActivePublishes(){
    global $connection;
    $tableData = '';

    $sqlQuery = "
    SELECT
           id_gallery,
           image_title,
           image_subtitle,
           image_status,
           user_name,
           desc_profile
    FROM ln_gallery, ln_users, ln_userprofile
    WHERE
          id_userpost = id_users
    AND
          id_userprofile = id_profile
    ";
    $resultset = mysqli_query($connection, $sqlQuery) or die("Error while processing data: " . mysqli_error());
    $rowCount = mysqli_num_rows($resultset);

    if($rowCount > 0) {
        while ($dataList = mysqli_fetch_array($resultset)) {
            $idGallery = $dataList['id_gallery'];
            $imageTitle = $dataList['image_title'];
            $imageSubtitle = $dataList['image_subtitle'];
            $imageStatus = $dataList['image_status'];
            $userName = $dataList['user_name'];
            $descProfile = $dataList['desc_profile'];

            $length = strlen($imageSubtitle);
            if($length <= 20) {
                $exhibitionImageSubtitle = $imageSubtitle;
            } else {
                $exhibitionImageSubtitle = substr($imageSubtitle, 0, 20) . "...";
            }

            if($imageStatus == 'PENDING_APPROVAL') {
                $showTranslate = 'Pendente de Aprovação';
                $btnOptionAccess = '
                    <a class="dropdown-item" href="javascript:void(0)" onclick="visualizePublish(' . $idGallery . ');">Visualizar Publicação</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="approvePublish(' . $idGallery . ');">Aprovar Publicação</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="sendToEditPublish(' . $idGallery . ');">Enviar para Edição</a>
                ';
            } else if ($imageStatus == 'APPROVED') {
                $showTranslate = 'Aprovado';
                $btnOptionAccess = '
                    <a class="dropdown-item" href="javascript:void(0)" onclick="visualizePublish(' . $idGallery . ');">Visualizar Publicação</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="sendToEditPublish(' . $idGallery . ');">Enviar para Edição</a>
                ';
            } else if ($imageStatus == 'TO_EDIT') {
                $showTranslate = 'Para Edição';
                $btnOptionAccess = '
                    <a class="dropdown-item" href="javascript:void(0)" onclick="visualizePublish(' . $idGallery . ');">Visualizar Publicação</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="callEditPublish(' . $idGallery . ');">Editar Publicação</a>
                    <a class="dropdown-item disabled" href="javascript:void(0)" onclick="removePublish(' . $idGallery . ');">Remover Publicação (Em breve)</a>
                ';
            }

            $tableLine = '
                <tr>
                    <th scope="row">' . $idGallery . '</th>
                    <td>' . $imageTitle . '</td>
                    <td>' . $exhibitionImageSubtitle . '</td>
                    <td>' . $showTranslate . '</td>
                    <td>' . $userName . '</td>
                    <td>' . $descProfile . '</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opções
                            </button>
                            <div class="dropdown-menu">
                                ' . $btnOptionAccess . '
                            </div>
                        </div>
                    </td>
                </tr>
            ';

            $tableData = $tableData . $tableLine;

            $table = '
                <table class="table table-striped table-bordered table-responsive-xl nowrap" id="table-list-users" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Título da Imagem</th>
                            <th scope="col">Subtítulo da Imagem</th>
                            <th scope="col">Status da Publicação</th>
                            <th scope="col">Usuário Publicador</th>
                            <th scope="col">Perfil de Acesso</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $tableData . '
                    </tbody>
                </table>
            ';
        }
    } else {
        return $table = '
            <table class="table table-striped table-bordered table-responsive-xl nowrap" id="table-list-users" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Título da Imagem</th>
                            <th scope="col">Subtítulo da Imagem</th>
                            <th scope="col">Status da Publicação</th>
                            <th scope="col">Usuário Publicador</th>
                            <th scope="col">Perfil de Acesso</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
        ';
    }

    return $table;
}