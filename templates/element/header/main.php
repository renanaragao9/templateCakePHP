<!-- Links da navbar esquerda -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" id="nav-icon" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <?= $this->element('header/menu') ?>
</ul>

<!-- Links da navbar direita -->
<ul class="navbar-nav ml-auto">
    <!-- Busca na Navbar -->
    <?= $this->element('header/search-block') ?>

    <!-- Menu Dropdown de Mensagens -->
    <?= $this->element('header/messages') ?>

    <!-- Menu Dropdown de Notificações -->
    <?= $this->element('header/notifications') ?>

    <li class="nav-item d-none d-md-block">
        <a class="nav-link" id="nav-icon" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link" id="nav-icon" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
        </a>
    </li> -->
    <li class="nav-item">
        <a class="nav-link" id="dark-mode-toggle" href="#" role="button">
            <i class="fas fa-moon"></i>
        </a>
    </li>
    <li class="nav-item d-none d-md-block">
        <a class="nav-link" id="nav-icon" href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'logout']) ?>" role="button">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>
    </li>
    <li class="nav-item d-block d-md-none">
        <a class="nav-link" id="nav-icon" href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'logout']) ?>" role="button">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </li>
</ul>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const toggleButton = $('#dark-mode-toggle');
        const darkModeEnabled = <?= json_encode($this->request->getSession()->read('dark-mode')) ?>;

        if (darkModeEnabled) {
            toggleButton.html('<i class="fas fa-sun"></i>');
            $('body').addClass('dark-mode');
        }

        toggleButton.on('click', function() {
            const isDarkMode = $('body').toggleClass('dark-mode').hasClass('dark-mode');
            toggleButton.html(isDarkMode ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>');

            $.post('<?= $this->Url->build(['controller' => 'AcademyConfig', 'action' => 'toggleDarkMode']) ?>', {
                _csrfToken: '<?= $this->request->getAttribute('csrfToken') ?>'
            });
        });
    });
</script>