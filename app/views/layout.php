<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Site de recettes'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <script src="http://localhost:8888/livereload.js"></script>
</head>
<body class="min-vh-100">
    <!-- header du site -->
    <?php require_once(__DIR__ . '/header.php'); ?>

    <!-- contenu du site -->
    <div>
        <?php echo $content; ?>
    </div>

    <!-- footer du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>