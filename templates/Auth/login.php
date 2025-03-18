<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Entrar</title>

    <?php echo $this->Html->meta('icon') ?>
    <?php echo $this->fetch('meta') ?>

    <!-- Icones e Fontes -->
    <?php echo $this->Html->css('CakeLte./AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>

    <!-- Estilo -->
    <?php echo $this->Html->css('Login/style_login.css') ?>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">

                <?php
                include __DIR__ . '/Components/Login/first_page.php';
                include __DIR__ . '/Components/Login/second_page.php';
                ?>
            </div>
        </div>

        <div class="panels-container">
            <?php
            include __DIR__ . '/Components/Login/third_page.php';
            ?>
        </div>
    </div>


    <?php
    echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js');
    echo $this->Html->script('Login/home.js');
    echo $this->Html->script('Login/view_password.js');
    ?>

    <!-- VLIBRAS
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script> -->
</body>

</html>