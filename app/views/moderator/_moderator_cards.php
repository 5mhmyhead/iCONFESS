<?php 
    /** @var Confession[] $confessions */
    /** @var string $status */

    $tagClasses = [
        'Love' => 'card-tag-love', 
        'Academic' => 'card-tag-academic',
        'Drama' => 'card-tag-drama', 
        'Miscellaneous' => 'card-tag-miscellaneous',
    ];
?>

<?php if(empty($confessions)): ?>
    <div id="register-error-alert" class="empty-state-full">
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

        <?php if ($status === 'flagged'): ?>
            <div class="report-details">
                <?php foreach ($confession -> getReports() as $report): ?>
                    <div class="report-entry">
                        <span class="report-reason-tag"><?= htmlspecialchars($report['reason']) ?></span>
                        <?php if (!empty($report['custom_reason'])): ?>
                            <p class="report-custom-text"><?= htmlspecialchars($report['custom_reason']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="card-footer">
            <?php if ($status === 'pending' || $status === 'flagged'): ?>
                <div class="mod-action-buttons">
                    <button type="button" class="mod-btn-reject" data-id="<?= (int)$confession -> getId() ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        reject
                    </button>
                    <button type="button" class="mod-btn-approve" data-id="<?= (int)$confession -> getId() ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        approve
                    </button>
                </div>
            <?php elseif ($status === 'approved' || $status === 'rejected'): ?>
                <div class="mod-action-buttons">
                    <button type="button" class="mod-btn-return" data-id="<?= (int)$confession -> getId() ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                        return to queue
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>