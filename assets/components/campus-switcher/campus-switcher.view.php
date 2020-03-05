<?php
$campuses = [
	'bloomington' => 'Bloomington',
	'evansville' => 'Evansville',
	'fort-wayne' => 'Fort Wayne',
	'indianapolis' => 'Indianapolis',
	'muncie' => 'Muncie',
	'gary' => 'Northwest – Gary',
	'south-bend' => 'South Bend',
	'terre-haute' => 'Terre Haute',
	'west-lafayette' => 'West Lafayette',
];
?>
<div class="component" id="campus-switcher">
	<h3>YOU ARE EXPLORING</h3>
	<div class="select-wrapper">
		<select class="form-control">
			<?php foreach ($campuses as $slug => $title) { ?>
				<option value="<?= $slug ?>"<?= (preg_match("@^campuses/$slug(/.*)?$@", $path)) ? ' selected' : '' ?>><?= $title ?></option>
			<?php } ?>
		</select>
	</div>
</div>
