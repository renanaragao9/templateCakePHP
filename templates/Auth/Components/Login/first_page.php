<!-- Primeira parte (TELA DE LOGIN) -->
<?php echo $this->Form->create(null, ['url' => ['controller' => 'Auth', 'action' => 'login'], 'class' => 'sign-in-form']) ?>

<h3 class="welcome-message">
    Bem-vindo ao sistema! Por favor, insira suas credenciais para acessar.
</h3>

<?php echo $this->Flash->render() ?>

<div class="input-field">
    <i class="fas fa-user"></i>
    <?php echo $this->Form->control(
        'email',
        [
            'type'        => 'email',
            'placeholder' => 'Email',
            'required'    => true,
            'label'       => false,
        ]
    ) ?>
</div>

<div class="input-field">
    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>

    <?php echo $this->Form->control(
        'password',
        [
            'type'        => 'password',
            'placeholder' => 'Senha',
            'required'    => true,
            'label'       => false,
            'id'          => 'password',
        ]
    ) ?>
</div>

<?php echo $this->Form->button(__('Entrar'), ['class' => 'btn solid']) ?>

<p class="social-text">Conheça nossas redes sociais</p>

<div class="social-media">
    <a href="#" class="social-icon">
        <i class="fab fa-facebook"></i>
    </a>

    <a href="https://www.instagram.com/aslasoftware/" target="_blank" class="social-icon">
        <i class="fab fa-instagram"></i>
    </a>

    <a href="#" class="social-icon">
        <i class="fab fa-twitter"></i>
    </a>

    <a href="https://api.whatsapp.com/send?phone=5585997373462" target="_blank" class="social-icon">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>
<?php echo $this->Form->end() ?>