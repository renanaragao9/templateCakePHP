<?php

?>
<!DOCTYPE html>
<html>
<head>
    <?=$this->Html->charset()?>
    <title>
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>

    <?=$this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake'])?>

    <?=$this->fetch('meta')?>
    <?=$this->fetch('css')?>
    <?=$this->fetch('script')?>
</head>
<body>
    <div class="error-container">
        <?=$this->Flash->render()?>
        <?=$this->fetch('content')?>
        <?=$this->Html->link(__('Back'), 'javascript:history.back()')?>
    </div>
</body>
</html>
