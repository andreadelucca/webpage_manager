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
    <title>Novo Upload | <?php echo $pageTitle; ?></title>
</head>
<body class="font-structure">

<?php include "../../inc/" . $navbarSystem; ?>

<div class="container">

    <br>

    <div class="row">

        <div class="col-md-5">
            <div class="jumbotron">
                <h1 class="display-4">Nova Publicação</h1>
                <p class="lead text-justify">Preencha adequadamente todos os campos, conforme se pede. Todas as imagens aqui publicadas estarão disponíveis na galeria, no site principal</p>
                <hr class="my-4">
                <p class="text-justify">Os campos com * são de caráter obrigatório</p>
            </div>
        </div>

        <div class="col-md-7">
            <div id="message-error-success">

            </div>
            <hr class="my-4">
            <form id="newupload-form" action="" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="imageTitle">Título da Imagem *</label>
                        <input type="text" class="form-control" id="txtImageTitle" name="txtImageTitle">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="imageSubtitle">Subtítulo da Imagem *</label>
                        <textarea name="txtImageSubtitle" id="txtImageSubtitle" rows="5" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="imageFile">Escolha o arquivo de foto (JPG, JPEG, TIFF) *</label>
                        <br>
                        <input type="file" name="txtImageFile" id="txtImageFile" accept="image/*">
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-success" id="buttonSubmitForm" onclick="sendDataUpload();">Salvar Dados</button>&nbsp;
                    <button type="button" class="btn btn-warning" id="buttonClearForm" onclick="resetForm();">Limpar Formulário</button>&nbsp;
                    <button type="button" class="btn btn-danger" id="buttonReturnPreviousPage" onclick="window.history.go(-1); return false;">Voltar a página anterior</button>
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

    const sendDataUpload = () => {
        let imageTitle = $('#txtImageTitle').val();
        let imageSubtitle = $('#txtImageSubtitle').val();
        let imageFile = $('#txtImageFile')[0].files;
        let processFile = '../../run/upload_files.php';

        let formData = new FormData();
        formData.append('imageTitle', imageTitle);
        formData.append('imageSubtitle', imageSubtitle);
        formData.append('imageFile', imageFile[0]);

        $.ajax({
            url: processFile,
            data: formData,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data) {
                let dataReturn = JSON.parse(data);
                if(dataReturn.return === 1) {
                    $("#message-error-success").html(dataReturn.messageSuccess);
                    setTimeout(function(){
                        location.reload();
                    }, 4000);
                } else {
                    $('#message-error-success').html(dataReturn.messageError);
                }
            },
            error: function (data) {
                console.log('Error: ' + data);
            }
        })
    }

    const resetForm = () => {
        document.getElementById("newupload-form").reset();
    }

</script>
</body>
</html>
