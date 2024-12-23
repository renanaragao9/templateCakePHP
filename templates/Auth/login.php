<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?=$this->Flash->render()?>
            <?=$this->Form->create()?>
            <div class="input-group mb-3">
                <?=$this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email'])?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <?=$this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password'])?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4">
                    <?=$this->Form->button(__('Sign In'), ['class' => 'btn btn-primary btn-block'])?>
                </div>
            </div>
            <?=$this->Form->end()?>
        </div>
    </div>
</div>