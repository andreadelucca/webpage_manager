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

    include "../../inc/config.php";
    global $pageTitle;
    global $githubLink;
    global $navbarSystem;

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
    <title>Início | <?php echo $pageTitle; ?></title>

</head>
<body class="font-structure">

    <?php include "../../inc/" . $navbarSystem; ?>
    <br>
    <div class="d-flex justify-content-center">
        <h3 class="text-center">Dashboard de Informações - Página Inicial</h3>
    </div>
    <hr class="my-4">
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="jumbotron">
                    <h1 class="display-4">Bem-vindo</h1>
                    <p class="lead text-justify">Aqui serão visualizados o que está pendente de ser aprovado ou que você mesmo pode publicar. Usuários, publicações, etc.</p>
                    <hr class="my-4">
                    <p class="text-justify">Clique abaixo no botão para iniciar uma publicação ou visualizar publicações pendentes</p>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Publique você mesmo</a>
                </div>
            </div>
            <div class="col-md-4">
                <div id="highcharts-publicacoes-pendentes">

                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <h4 class="text-center">Usuários Ativos no Sistema</h4>
                    <hr class="my-4">
                    <h1 class="d-flex justify-content-center display-4">6</h1>
                    <br>
                    <h4 class="text-center">Usuários Inativos no Sistema</h4>
                    <hr class="my-4">
                    <h1 class="d-flex justify-content-center display-4">3</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h4>Publicações pendentes de Aprovação</h4>
                    <hr class="my-4">
                    <table class="table table-striped table-bordered table-responsive-lg nowrap" id="table-pending-approval" style="width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">ID da Publicação</th>
                            <th scope="col">Publicação</th>
                            <th scope="col">Publicador</th>
                            <th scope="col">Caminho da Imagem</th>
                            <th scope="col">Título da Imagem</th>
                            <th scope="col">Descrição da Imagem</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>

        // -------------------------------------------- Datatables Script ----------------------------------------------

        $(document).ready( function () {
            $('#table-pending-approval').DataTable({
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

       // -------------------------------------- End of Datatables Script ----------------------------------------------

       // ------------------------------------------- Highcharts Graphic -----------------------------------------------

        Highcharts.chart('highcharts-publicacoes-pendentes', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Publicações no Sistema'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Pendentes',
                    y: 61.41
                }, {
                    name: 'Reprovadas',
                    y: 11.84
                }, {
                    name: 'Aprovadas',
                    y: 7.05
                }]
            }]
        });

        // ---------------------------------------- End of Highcharts Graphic ------------------------------------------
    </script>
</body>
</html>