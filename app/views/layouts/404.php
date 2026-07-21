<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <div class="error-page">
        <div class="error-code">40<span>4</span></div>
        <h1 class="error-title">Lost in the <span>Confessions?</span></h1>
        <p class="error-message">
            <?php echo htmlspecialchars($errorMessage ?? "The page you're looking for doesn't exist or has been moved."); ?>
        </p>
         <a href="?url=confessions" class="btn-home">Return to Confession Feed</a>
     </div>
</body>
</html>