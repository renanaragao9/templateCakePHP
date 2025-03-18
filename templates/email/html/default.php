<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap");

        body {
            font-family: "Outfit", sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            color: #495057;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 8px solid #868e96;
            border-right: 8px solid #868e96;
        }

        .email-header {
            background-color: rgba(134, 142, 150, 0.1);
            color: #000;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .email-image {
            width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .email-body {
            padding: 24px;
            font-size: 1.2rem;
            line-height: 1.5;
        }

        .email-body p {
            margin: 0 0 16px;
        }

        .email-footer {
            background-color: #f1f3f5;
            text-align: center;
            padding: 16px;
            font-size: 14px;
            color: #868e96;
        }

        .btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            text-align: center;
            font-size: 18px;
            padding: 10px 20px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Imagem no topo -->
        <img src="<?= $this->Url->image('home/Gym-amico.png', ['fullBase' => true]) ?>" alt="Imagem do topo" class="email-image">
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