<?php /** @var Confession[] $confessions */ ?>

<?php if(empty($confessions)): ?>
    No confessions found.
<?php endif; ?>

<?php foreach($confessions as $confession): ?>
    <div class="confession-card">
        <div class="card-header">
            <div class="card-header-left">
                <span class="card-id">#iConfess<?= htmlspecialchars($confession -> getId()) ?></span>
                <span class="card-tag"><?= htmlspecialchars($confession -> getCategory()) ?></span>
            </div>
            <span class="card-time">Add Time here</span>
        </div>

        <p class="card-title"><?= htmlspecialchars($confession -> getTitle()) ?></p>
        <p class="card-content"><?= htmlspecialchars($confession -> getContent()) ?></p>
        
        <hr class="card-divider">

        <div class="card-footer">
            <span><?= (int) $confession -> getHearts() ?> hearts</span>
        </div>
    </div>
<?php endforeach; ?>