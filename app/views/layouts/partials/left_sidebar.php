<?php
    /** @var string|null $category */
    /** @var string|null $sort     */
    /** @var string|null $campus   */
    /** @var array|null $current   */
?>

<aside class="sidebar">
    <div class="sidebar-label noselect">BOARDS</div>
    <a href="<?= $this -> filterUrl(['category' => ''], $current) ?>" class="sidebar-link <?= empty($category) ? 'active' : '' ?>">all confessions</a>
    <a href="<?= $this -> filterUrl(['category' => 'Academic'], $current) ?>" class="sidebar-link <?= $category === 'Academic' ? 'active' : '' ?>">academic</a>
    <a href="<?= $this -> filterUrl(['category' => 'Love'], $current) ?>" class="sidebar-link <?= $category === 'Love' ? 'active' : '' ?>">love</a>
    <a href="<?= $this -> filterUrl(['category' => 'Drama'], $current) ?>" class="sidebar-link <?= $category === 'Drama' ? 'active' : '' ?>">drama</a>
    <a href="<?= $this -> filterUrl(['category' => 'Miscellaneous'], $current) ?>" class="sidebar-link <?= $category === 'Miscellaneous' ? 'active' : '' ?>">miscellaneous</a>

    <hr class="sidebar-divider">

    <div class="sidebar-label noselect">CAMPUS</div>
    <a href="<?= $this -> filterUrl(['campus' => ''], $current) ?>" class="sidebar-link <?= empty($campus) ? 'active' : '' ?>">all campuses</a>
    <a href="<?= $this -> filterUrl(['campus' => 'Makati'], $current) ?>" class="sidebar-link <?= $campus === 'Makati' ? 'active' : '' ?>">makati</a>
    <a href="<?= $this -> filterUrl(['campus' => 'Cebu'], $current) ?>" class="sidebar-link <?= $campus === 'Cebu' ? 'active' : '' ?>">cebu</a>
</aside>