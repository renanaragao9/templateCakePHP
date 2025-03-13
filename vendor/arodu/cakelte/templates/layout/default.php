<?php

use Cake\Core\Configure;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') . ' | ' . strip_tags($this->CakeLte->getConfig('app-name')) ?></title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?= $this->Html->css('CakeLte./AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>
    <?= $this->Html->css('CakeLte./AdminLTE/dist/css/adminlte.min.css') ?>
    <?= $this->Html->css('CakeLte.style') ?>
    <?= $this->element('layout/css') ?>
    <?= $this->fetch('css') ?>
    <?= $this->Html->css('headerConfig.css') ?>
</head>

<body class="hold-transition <?= $this->CakeLte->getBodyClass() ?>">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand <?= $this->CakeLte->getHeaderClass() ?>">
            <?= $this->element('header/main') ?>
        </nav>

        <aside class="main-sidebar <?= $this->CakeLte->getSidebarClass() ?>">
            <a href="<?= $this->Url->build('/') ?>" class="brand-link">
                <?= $this->Html->image('logo/logo.png', [
                    'alt' => Configure::read('App.name') . ' logo',
                    'class' => 'brand-image',
                    'fullBase' => true,
                ]) ?>
                <span class="brand-text font-weight-light"><?= Configure::read('App.name') ?></span>
            </a>
            <div class="sidebar">
                <?= $this->element('sidebar/main') ?>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="container-fluid">
                <?= $this->element('content/header') ?>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                    <div id="loader" class="loader" style="display: none;">
                        <div class="gym-loader">
                            <i class="fas fa-dumbbell icon"></i>
                            <i class="fas fa-running icon"></i>
                            <i class="fas fa-bicycle icon"></i>
                        </div>
                    </div>
                    <nav class="navbar fixed-bottom navbar-light bg-light mobile-navbar">
                        <div class="container-fluid justify-content-around">
                            <a class="navbar-brand" href="#">
                                <i class="fa-regular fa-magnifying-glass"></i>
                            </a>
                            <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">
                                <i class="fa-regular fa-house-blank"></i> </a>
                            <a class="navbar-brand" href="#">
                                <i class="fa-regular fa-user"></i> </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <?= $this->element('aside/main') ?>
        </aside>

        <footer class="main-footer">
            <?= $this->element('footer/main') ?>
        </footer>
    </div>

    <?= $this->Html->script('CakeLte./AdminLTE/plugins/jquery/jquery.min.js') ?>
    <?= $this->Html->script('CakeLte./AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>
    <?= $this->Html->script('CakeLte./AdminLTE/dist/js/adminlte.min.js') ?>

    <?= $this->element('layout/script') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('config/loader.js') ?>
    <?= $this->Html->script('config/spinner.js') ?>
    <?= $this->Html->script('config/filter.js') ?>
</body>

</html>