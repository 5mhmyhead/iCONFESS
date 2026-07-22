<?php
    /** @var string|null $category */
    /** @var string|null $sort     */
    /** @var string|null $campus   */
?>

<aside class="sidebar">
    <div class="sidebar-label noselect">BOARDS</div>
    <div class="sidebar-link <?= empty($category) ? 'active' : '' ?>" data-category="">all confessions</div>
    <div class="sidebar-link <?= $category === 'Academic' ? 'active' : '' ?>" data-category="Academic">academic</div>
    <div class="sidebar-link <?= $category === 'Love' ? 'active' : '' ?>" data-category="Love">love</div>
    <div class="sidebar-link <?= $category === 'Drama' ? 'active' : '' ?>" data-category="Drama">drama</div>
    <div class="sidebar-link <?= $category === 'Miscellaneous' ? 'active' : '' ?>" data-category="Miscellaneous">miscellaneous</div>

    <hr class="sidebar-divider">

    <div class="sidebar-label noselect">CAMPUS</div>
    <div class="sidebar-link <?= empty($campus) ? 'active' : '' ?>" data-campus="">all campuses</div>
    <div class="sidebar-link <?= $campus === 'Makati' ? 'active' : '' ?>" data-campus="Makati">makati</div>
    <div class="sidebar-link <?= $campus === 'Cebu' ? 'active' : '' ?>" data-campus="Cebu">cebu</div>
</aside>