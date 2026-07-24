<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($errorCode ?? '404'); ?> - Error</title>

    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <div class="error-page">
        <?php 
            $code = $errorCode ?? '404';
            $firstPart = substr($code, 0, -1);
            $lastChar = substr($code, -1);
        ?>
        
        <div class="error-code"><?php echo htmlspecialchars($firstPart); ?><span><?php echo htmlspecialchars($lastChar); ?></span></div>
        
        <h1 class="error-title">
            <?php if ($code == '403'): ?>
                Access <span>Forbidden</span>
            <?php elseif ($code == '500'): ?>
                Server <span>Error</span>
            <?php else: ?>
                Lost in the <span>Confessions?</span>
            <?php endif; ?>
        </h1>

        <p class="error-message">
            <?php 
                if (isset($errorMessage)) {
                    echo htmlspecialchars($errorMessage);
                } else {
                    if ($code == '403') {
                        echo "You don't have permission to access this page.";
                    } elseif ($code == '500') {
                        echo "Something went wrong on our end. Please try again later.";
                    } else {
                        echo "The page you're looking for doesn't exist or has been moved.";
                    }
                }
            ?>
        </p>

        <a href="?url=confessions" class="btn-home">Return to Confession Feed</a>
     </div>
</body>
</html>