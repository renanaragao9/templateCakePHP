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

                <?php echo $this->Form->create(null, ['url' => ['controller' => 'Auth', 'action' => 'changePassword', $token], 'class' => 'sign-in-form']) ?>

                <h3 class="welcome-message">
                    Redefina sua senha para continuar acessando o sistema.
                </h3>

                <?php echo $this->Flash->render() ?>

                <!-- Campo oculto para o token -->
                <?php echo $this->Form->hidden('token', ['value' => $token]) ?>

                <div class="input-field">
                    <i class="fas fa-eye" id="toggleNewPassword" style="cursor: pointer;"></i>
                    <?php echo $this->Form->control(
                        'password',
                        [
                            'type'        => 'password',
                            'placeholder' => 'Nova senha',
                            'required'    => true,
                            'label'       => false,
                            'id'          => 'new-password',
                        ]
                    ) ?>
                </div>

                <div class="input-field">
                    <i class="fas fa-eye" id="toggleConfirmPassword" style="cursor: pointer;"></i>
                    <?php echo $this->Form->control(
                        'confirm_password',
                        [
                            'type'        => 'password',
                            'placeholder' => 'Confirmar senha',
                            'required'    => true,
                            'label'       => false,
                            'id'          => 'confirm-password',
                        ]
                    ) ?>
                </div>

                <?php echo $this->Form->button(__('Enviar'), ['class' => 'btn solid']) ?>

                <?php echo $this->Form->end() ?>
            </div>
        </div>

        <!-- Solicitação de ACESSO-->
        <div class="panels-container">
            <div class="panel left-panel">
                <img src="<?php echo $this->Url->build('/img/home/Gym-rafiki.png') ?>" class="image" />
            </div>
        </div>
    </div>


    <?php
    echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js');
    echo $this->Html->script('Login/home.js');
    echo $this->Html->script('Login/view_password.js');
    ?>

    <!-- VLIBRAS -->
    <!-- Código da VLibras
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