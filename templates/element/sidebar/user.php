<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  <div class="image">
    <?=$this->Html->image('CakeLte./AdminLTE/dist/img/user2-160x160.jpg', ['class' => 'img-circle elevation-2', 'alt' => 'Imagem do Usuário'])?>
  </div>
  <div class="info">
    <a href="#" class="d-block"><?=$this->request->getSession()->read('Auth.User.name');?></a>
  </div>
</div>