<?php 
    /** @var Confession[] $confessions */ 

    $tagClasses = [
        'Love' => 'card-tag-love', 
        'Academic' => 'card-tag-academic',
        'Drama' => 'card-tag-drama', 
        'Miscellaneous' => 'card-tag-miscellaneous',
    ];
?>

<?php if(empty($confessions)): ?>
    <div id="register-error-alert" style="margin: 30px;">
        No confessions found.
    </div>
<?php endif; ?>

<?php foreach($confessions as $confession): ?>
    <?php $tagClass = $tagClasses[$confession -> getCategory()] ?? 'card-tag-miscellaneous'; ?>
    <div class="confession-card">
        <div class="card-header">
            <div class="card-header-left">
                <span class="card-id">#iConfess<?= htmlspecialchars($confession -> getId()) ?></span>
                <span class="card-campus"><?= htmlspecialchars($confession -> getCampus()) ?></span>
                <span class="card-category <?= htmlspecialchars($tagClass) ?>">
                    <?= htmlspecialchars($confession -> getCategory() === 'Miscellaneous' ? 'Misc' : $confession -> getCategory()) ?>
                </span>
            </div>
            <span class="card-time"><?= htmlspecialchars($confession -> getFormattedTime()) ?></span>
        </div>

        <p class="card-title"><?= htmlspecialchars($confession -> getTitle()) ?></p>
        <p class="card-content"><?= htmlspecialchars($confession -> getContent()) ?></p>
        
        <hr class="card-divider">

        <div class="card-footer">
            <button type="button" class="heart-btn" data-id="<?= (int)$confession -> getId() ?>" data-liked="<?= $confession -> isLiked() ? 'true' : 'false' ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9896a8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l8.84 8.84 8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span><?= (int) $confession->getHearts() ?> hearts</span>
            </button>
            
            <button type="button" class="report-btn" data-id="<?= (int)$confession -> getId() ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#505050" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 15C4 15 5 14 8 14C11 14 13 16 16 16C19 16 20 15 20 15V3C20 3 19 4 16 4C13 4 11 2 8 2C5 2 4 3 4 3V15ZM4 15V22"/>
                </svg>
                <span>report</span>
            </button>
        </div>
    </div>
<?php endforeach; ?>