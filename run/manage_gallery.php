<?php
session_start();
include '../inc/config.php';
include '../inc/main_functions.php';

$message = $_POST['message'];
$idGallery = $_POST['idGallery'];

function loadGalleryVisualize($idGallery) {
    global $connection;

    $sqlQuery = "select * from ln_gallery, ln_users where id_userpost = id_users and id_gallery = $idGallery";
    $resultset = mysqli_query($connection, $sqlQuery) or die ("Error while fetching data: " . mysqli_error($connection));
    $numRows = mysqli_num_rows($resultset);

    if($numRows > 0) {
        $returnJSON = 1;
        while ($data = mysqli_fetch_array($resultset)) {
            $id_gallery = $data['id_gallery'];
            $image_title = $data['image_title'];
            $image_subtitle = $data['image_subtitle'];
            $image_path = $data['image_path'];
            $id_userpost = $data['id_userpost'];
            $user_name = $data['user_name'];
        }
    } else {
        $returnJSON = 0;
        $messageError = style_short_alerts('danger', 'Erro!', 'Post não disponível ou erro na pesquisa.');
        $messageSuccess = '';
    }

    $returnData['returnJSON'] = $returnJSON;
    $returnData['messageError'] = $messageError;
    $returnData['messageSuccess'] = $messageSuccess;
    $returnData['imageId'] = $id_gallery;
    $returnData['imageTitle'] = $image_title;
    $returnData['imageSubtitle'] = $image_subtitle;
    $returnData['imageFile'] = $image_path;
    $returnData['userPostId'] = $id_userpost;
    $returnData['userName'] = $user_name;

    echo $processJSON = json_encode($returnData);
    return $processJSON;

}

function approvePublish($idGallery) {
    global $connection;

    $sqlQuery = "UPDATE ln_gallery SET image_status = 'APPROVED' where id_gallery = $idGallery";
    $resultset = mysqli_query($connection, $sqlQuery) or die ("Error while fetching data: " . mysqli_error($connection));
    $numRows = mysqli_affected_rows($connection);

    if($numRows > 0) {
        $returnJSON['return'] = 1;
        $returnJSON['messageSuccess'] = style_short_alerts('success', 'Atualizada!', 'Publicação aprovada e disponível na página principal. Aguarde enquanto recarregamos a página!');
        $returnJSON['messageError'] = '';
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = style_short_alerts('success', 'Erro!', 'Publicação não aprovada devido a um erro! Tente novamente');
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function sendToEditPublish($idGallery) {
    global $connection;

    $sqlQuery = "UPDATE ln_gallery SET image_status = 'TO_EDIT' where id_gallery = $idGallery";
    $resultset = mysqli_query($connection, $sqlQuery) or die ("Error while fetching data: " . mysqli_error($connection));
    $numRows = mysqli_affected_rows($connection);

    if($numRows > 0) {
        $returnJSON['return'] = 1;
        $returnJSON['messageSuccess'] = style_short_alerts('success', 'Atualizada!', 'Publicação enviada para edição. Aguarde enquanto recarregamos a página!');
        $returnJSON['messageError'] = '';
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = style_short_alerts('success', 'Erro!', 'Publicação não enviada para edição devido a um erro! Tente novamente');
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

function callEditPublish($idGallery) {
    global $connection;
    $sqlQuery = "select * from ln_gallery, ln_users where id_userpost = id_users and id_gallery = $idGallery";
    $resultset = mysqli_query($connection, $sqlQuery) or die ("Error while fetch data: " . mysqli_error($connection));
    $numRows = mysqli_num_rows($resultset);

    if($numRows > 0) {
        $returnJSON = 1;
        while ($data = mysqli_fetch_array($resultset)) {
            $id_gallery = $data['id_gallery'];
            $image_title = $data['image_title'];
            $image_subtitle = $data['image_subtitle'];
            $image_path = $data['image_path'];
            $id_userpost = $data['id_userpost'];
            $user_name = $data['user_name'];

            unlink($image_path);
        }
    } else {
        $returnJSON = 0;
        $messageError = style_short_alerts('danger', 'Erro!', 'Post não disponível ou erro na pesquisa.');
        $messageSuccess = '';
    }

    $returnData['returnJSON'] = $returnJSON;
    $returnData['messageError'] = $messageError;
    $returnData['messageSuccess'] = $messageSuccess;
    $returnData['imageId'] = $id_gallery;
    $returnData['imageTitle'] = $image_title;
    $returnData['imageSubtitle'] = $image_subtitle;
    $returnData['imageFile'] = $image_path;
    $returnData['userPostId'] = $id_userpost;
    $returnData['userName'] = $user_name;

    echo $processJSON = json_encode($returnData);
    return $processJSON;
}

function saveGalleryEdit($idGallery) {
    global $connection;

    $imageTitle = $_POST['imageTitle'];
    $imageSubtitle = $_POST['imageSubtitle'];
    $errors = 0;

    if(strlen(trim($imageTitle)) <= 0) {
        $errors++;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar dados!', 'Título da imagem não pode estar vazio');
    } else if (strlen(trim($imageSubtitle)) <= 0) {
        $errors++;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar dados!', 'Subtítulo da imagem não pode estar vazio');
    }

    $validExtensions = array('jpeg','jpg');
    $filepath = "../uploads/";
    $imageFile = $_FILES['imageFile']['name'];
    $tempImage = $_FILES['imageFile']['tmp_name'];
    $extensionImage = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
    $finalImage = rand(1000,10000000).basename($imageFile);

    if($errors == 0) {
        if($imageFile) {
            if(in_array($extensionImage, $validExtensions)) {
                $filepath = $filepath.strtolower($finalImage);
                if(move_uploaded_file($tempImage, $filepath)) {

                    $sqlQuery = "UPDATE ln_gallery SET image_title = '$imageTitle', image_subtitle = '$imageSubtitle', image_path = '$filepath', image_status = 'PENDING_APPROVAL' WHERE id_gallery =  $idGallery;";
                    $resultset = mysqli_query($connection, $sqlQuery) or die('Error while updating data: ' . mysqli_error($connection));
                    $numRows = mysqli_affected_rows($connection);

                    if($numRows > 0){
                        $returnJSON['return'] = 1;
                        $returnJSON['messageSuccess'] = style_short_alerts('success', 'Atualizado com sucesso!', 'Post atualizado com sucesso. Aguarde enquanto recarregamos a página');
                        $returnJSON['messageError'] = '';
                    } else {
                        $returnJSON['return'] = 0;
                        $returnJSON['messageSuccess'] = '';
                        $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar dados!', 'Houve um erro ao processar os dados. Tente novamente');
                    }
                } else {
                    $returnJSON['return'] = 0;
                    $returnJSON['messageSuccess'] = '';
                    $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar dados!', 'Erro interno ao validar dados. Tente novamente');
                }
            } else {
                $returnJSON['return'] = 0;
                $returnJSON['messageSuccess'] = '';
                $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar dados!', 'Formato de imagem não permitido! Apenas arquivos JPEG e JPG são aceitos');
            }
        } else {
            $returnJSON['return'] = 0;
            $returnJSON['messageSuccess'] = '';
            $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao atualizar dados!', 'Inserção de imagem é obrigatória. Carregue uma imagem e tente novamente');
        }
    }

    echo $processJSON = json_encode($returnJSON);
    return $processJSON;
}

if($message == 'VISUALIZE') {
    loadGalleryVisualize($idGallery);
} else if ($message == 'APPROVE') {
    approvePublish($idGallery);
} else if ($message == 'TO_EDIT') {
    sendToEditPublish($idGallery);
} else if ($message == 'EDIT') {
    callEditPublish($idGallery);
} else if ($message == 'SAVE_EDIT') {
    saveGalleryEdit($idGallery);
}
