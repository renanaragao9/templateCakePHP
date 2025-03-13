<!-- Painel do usuário na barra lateral (opcional) -->
<?= $this->element('sidebar/user') ?>
<?php // echo $this->element('sidebar/search') 
?>

<!-- Menu da Barra Lateral -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column <?= $this->CakeLte->getMenuClass() ?>" data-widget="treeview" role="menu" data-accordion="false">
        <?php echo $this->element('sidebar/menu') ?>
    </ul>
</nav>