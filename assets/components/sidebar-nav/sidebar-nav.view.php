<?php
/**
 * View template for sidebar-nav
 */

if (!isset($parent_id)) {
	$parent_id = false;
}
?>
<div id="sidebar-nav" class="collapse-mobile" data-current="<?= $current_path; ?>">
	<h2 class="menu-toggle desktop-hide">In This Section:</h2>
	<nav role="navigation" aria-label="Sidebar Navigation" class="menu-wrapper">
		<?= $items; ?>
	</nav>
</div>
