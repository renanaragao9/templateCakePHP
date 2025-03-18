<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php echo $this->Html->css('Email/index.css') ?>
</head>

<body>
    <div class="email-container">
        <!-- Imagem no topo -->
        <img src="<?php echo $this->Url->build('/img/home/Gym-amico.png') ?>" alt="Imagem do topo" class="email-image">
        <div class="email-header">
            Notificação
        </div>

        <div class="email-body">
            <p>Olá, <?= h($userName) ?>,</p>

            <?php foreach ($content as $line): ?>
                <p><?= h($line) ?></p>
            <?php endforeach; ?>
            <a href="<?= $url ?>" class="btn btn-secondary">Acessar</a>
        </div>
        <div class="email-footer">
            <p>&copy; <?= date('Y') ?> Template Todos os direitos reservados.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>