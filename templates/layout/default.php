<?php

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') . ' | ' . strip_tags($this->CakeLte->getConfig('app-name')) ?></title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <?= $this->Html->css('CakeLte./AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>
    <!-- Tema -->
    <?= $this->Html->css('CakeLte./AdminLTE/dist/css/adminlte.min.css') ?>
    <?= $this->Html->css('CakeLte.style') ?>
    <?= $this->element('layout/css') ?>
    <?= $this->fetch('css') ?>
    <?= $this->Html->css('headerConfig.css') ?>
</head>

<body class="hold-transition <?= $this->CakeLte->getBodyClass() ?>">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand <?= $this->CakeLte->getHeaderClass() ?>">
            <?= $this->element('header/main') ?>
        </nav>
        <!-- /.navbar -->

        <!-- Container Principal da Barra Lateral -->
        <aside class="main-sidebar <?= $this->CakeLte->getSidebarClass() ?>">
            <!-- Logo da Marca -->
            <a href="<?= $this->Url->build('/') ?>" class="brand-link">
                <?= $this->Html->image($this->CakeLte->getConfig('app-logo'), ['alt' => $this->CakeLte->getConfig('app-name') . ' logo', 'class' => 'brand-image']) ?>
                <span class="brand-text font-weight-light"><?= $this->CakeLte->getConfig('app-name') ?></span>
            </a>
            <!-- Barra Lateral -->
            <div class="sidebar">
                <?= $this->element('sidebar/main') ?>
            </div>
            <!-- /.barra lateral -->
        </aside>

        <!-- Container de Conteúdo. Contém o conteúdo da página -->
        <div class="content-wrapper">
            <!-- Cabeçalho do Conteúdo (Cabeçalho da Página) -->
            <div class="content-header">
                <div class="container-fluid">
                    <?= $this->element('content/header') ?>
                </div><!-- /.container-fluid -->
            </div>

            <!-- Conteúdo Principal -->
            <div class="content">
                <div class="container-fluid">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.conteúdo -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Barra Lateral de Controle -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- O conteúdo da barra lateral de controle vai aqui -->
            <?= $this->element('aside/main') ?>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Rodapé Principal -->
        <footer class="main-footer">
            <?= $this->element('footer/main') ?>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <?= $this->Html->script('CakeLte./AdminLTE/plugins/jquery/jquery.min.js') ?>
    <!-- Bootstrap 4 -->
    <?= $this->Html->script('CakeLte./AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>
    <!-- AdminLTE App -->
    <?= $this->Html->script('CakeLte./AdminLTE/dist/js/adminlte.min.js') ?>

    <?= $this->element('layout/script') ?>
    <?= $this->fetch('script') ?>
</body>

</html>