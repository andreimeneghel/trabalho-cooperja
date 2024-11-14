<?php $BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";
?>
<head>
<link rel="stylesheet" href="/templates/site/assets/css/header.css">
</head>

<header class="navbar navbar-expand-md navbar-dark sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/dashboard"><img style="width: 100px;" src="/templates/site/assets/img/logoCooperjaBranca.png" alt=""></a>
        <div class="d-flex ms-auto">
            <a class="btn btn-outline-light btn-sm" href="<?= $BASE_URL ?>logout.php">Sair</a>
        </div>
    </div>
</header>