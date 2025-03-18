<?php echo $this->Form->create(null, ['url' => ['controller' => 'Auth', 'action' => 'resetPassword'], 'class' => 'sign-up-form']) ?>

<h2 class="title">Redefinir senha</h2>

<?php echo $this->Flash->render() ?>

<div class="input-field">
    <i class="fas fa-envelope"></i>
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

<?php echo $this->Form->button(__('Enviar'), ['class' => 'btn solid']) ?>

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