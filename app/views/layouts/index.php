<?php /** @var string $content */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iACADEMY Confessions</title>

    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <?php include '../app/views/layouts/page_loader.php'; ?>
    <main class="container py-4">
        <?= $content ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/confessions.js"></script>
</body>
</html>