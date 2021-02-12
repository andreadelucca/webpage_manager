<?php

session_start();
include '../inc/config.php';
include '../inc/main_functions.php';
include '../inc/data_functions.php';

global $connection;

$idUser = $_SESSION['id_user'];
$imageTitle = $_POST['imageTitle'];
$imageSubtitle = $_POST['imageSubtitle'];
$errors = 0;

if(strlen(trim($imageTitle)) <= 0) {
    $errors++;
    $returnJSON['messageSuccess'] = '';
    $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao salvar dados!', 'Título da imagem não pode estar vazio');
} else if (strlen(trim($imageSubtitle)) <= 0) {
    $errors++;
    $returnJSON['messageSuccess'] = '';
    $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao salvar dados!', 'Subtítulo da imagem não pode estar vazio');
}

# Permitted extensions in image upload
$validExtensions = array('jpeg','jpg');

# Set default folder for uploaded images
$filepath = "../uploads/";

# Image name
$imageFile = $_FILES['imageFile']['name'];

# Temporary image address
$tempImage = $_FILES['imageFile']['tmp_name'];

# Get the extension file
$extensionImage = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));

# To avoid same files - Give an random name for image
$finalImage = rand(1000,1000000).$imageFile;

if($errors == 0) {
    if($imageFile) {
        if(in_array($extensionImage, $validExtensions)) {
            $filepath = $filepath.strtolower($finalImage);
            if(move_uploaded_file($tempImage, $filepath)) {

                $sqlQuery = "INSERT INTO ln_gallery VALUES (null, '$imageTitle', '$imageSubtitle', '$filepath', $idUser);";
                $resultset = mysqli_query($connection, $sqlQuery) or die('Error while saving data: ' . mysqli_error($connection));
                $numRows = mysqli_affected_rows($connection);

                if($numRows > 0){
                    $returnJSON['return'] = 1;
                    $returnJSON['messageSuccess'] = style_short_alerts('success', 'Salvo com sucesso!', 'Post realizado com sucesso. Aguarde enquanto recarregamos a página');
                    $returnJSON['messageError'] = '';
                } else {
                    $returnJSON['return'] = 0;
                    $returnJSON['messageSuccess'] = '';
                    $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao salvar dados!', 'Houve um erro ao processar os dados. Tente novamente');
                }
            } else {
                $returnJSON['return'] = 0;
                $returnJSON['messageSuccess'] = '';
                $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao salvar dados!', 'Erro interno ao validar dados. Tente novamente');
            }
        } else {
            $returnJSON['return'] = 0;
            $returnJSON['messageSuccess'] = '';
            $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao salvar dados!', 'Formato de imagem não permitido! Apenas arquivos JPEG e JPG são aceitos');
        }
    } else {
        $returnJSON['return'] = 0;
        $returnJSON['messageSuccess'] = '';
        $returnJSON['messageError'] = style_short_alerts('danger', 'Erro ao salvar dados!', 'Inserção de imagem é obrigatória. Carregue uma imagem e tente novamente');
    }
}

echo $processJSON = json_encode($returnJSON);