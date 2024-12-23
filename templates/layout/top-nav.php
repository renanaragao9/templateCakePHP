<?php

/**
 * @var \App\View\AppView $this
 * @var \CakeLte\View\Helper\CakeLteHelper $this->CakeLte
 */

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->fetch('title') . ' | ' . strip_tags($this->CakeLte->getConfig('app-name'))?></title>

    <?=$this->Html->meta('icon')?>
    <?=$this->fetch('meta')?>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <?=$this->Html->css('CakeLte./AdminLTE/plugins/fontawesome-free/css/all.min.css')?>
    <!-- Tema -->
    <?=$this->Html->css('CakeLte./AdminLTE/dist/css/adminlte.min.css')?>
    <?=$this->Html->css('CakeLte.style')?>
    <?=$this->element('layout/css')?>
    <?=$this->fetch('css')?>
</head>

<body class="hold-transition layout-top-nav <?=$this->CakeLte->getBodyClass()?>">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md <?=$this->CakeLte->getHeaderClass()?>">
            <div class="container">
                <a href="<?=$this->Url->build('/')?>" class="navbar-brand">
                    <?=$this->Html->image($this->CakeLte->getConfig('app-logo'), ['alt' => $this->CakeLte->getConfig('app-name') . ' logo', 'class' => 'brand-image'])?>
                    <span class="brand-text font-weight-light"><?=$this->CakeLte->getConfig('app-name')?></span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Links da navbar esquerda -->
                    <ul class="navbar-nav">
                        <?php echo $this->element('header/menu') ?>
                    </ul>

                    <!-- FORMULÁRIO DE BUSCA -->
                    <?php echo $this->element('header/search-default') ?>
                </div>

                <!-- Links da navbar direita -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- Menu Dropdown de Mensagens -->
                    <?php echo $this->element('header/messages') ?>

                    <!-- Menu Dropdown de Notificações -->
                    <?php echo $this->element('header/notifications') ?>


                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Container de Conteúdo. Contém o conteúdo da página -->
        <div class="content-wrapper">
            <!-- Cabeçalho do Conteúdo (Cabeçalho da Página) -->
            <div class="content-header">
                <div class="container">
                    <?=$this->element('content/header')?>
                </div><!-- /.container-fluid -->
            </div>

            <!-- Conteúdo Principal -->
            <div class="content">
                <div class="container">
                    <?=$this->Flash->render()?>
                    <?=$this->fetch('content')?>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.conteúdo -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Barra Lateral de Controle -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- O conteúdo da barra lateral de controle vai aqui -->
            <?=$this->element('aside/main')?>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Rodapé Principal -->
        <footer class="main-footer">
            <div class="container">
                <?=$this->element('footer/main')?>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <?=$this->Html->script('CakeLte./AdminLTE/plugins/jquery/jquery.min.js')?>
    <!-- Bootstrap 4 -->
    <?=$this->Html->script('CakeLte./AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')?>
    <!-- AdminLTE App -->
    <?=$this->Html->script('CakeLte./AdminLTE/dist/js/adminlte.min.js')?>

    <?=$this->element('layout/script')?>
    <?=$this->fetch('script')?>
</body>

</html>