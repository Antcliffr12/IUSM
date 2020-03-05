<?php
$instites = [
	'aging-research' => 'Aging Research',
	'aids' => 'AIDS',
	'alcohol' => 'Alcohol',
	'alzheimers'=> 'Alzheimer\'s',
	'bioethics' => 'Bioethics',
	'bowen-health-workforce' => 'Bowen Health Workforce',
	'brain-center' => 'BRAIN Center',
	'breast-cancer' => 'Breast Cancer',
	'childrens-health-services' => 'Children’s Health Services Research Center',
	'pediatric-adolescent-comparative-effectiveness' => 'Comparative Effectiveness',
	'diabetes-metabolic-diseases' => 'Diabetes',
	'hpv' => 'HPV',
	'immunotherapy' => 'Immunotherapy',
	'personalized-medicine' => 'Personalized Medicine',
	'musculoskeletal-health' => 'Musculoskeletal Health',
	'regenerative-medicine-and-engineering' => 'Regenerative Medicine and Engineering',	
	'stark-neurosciences' => 'Stark Neurosciences Research Institute',
	'traumatic-brain-injury-model-system' => 'Traumatic Brain Injury Model Systems',
	'wells-pediatric-research' => 'Wells Center for Pediatric Research',
];
?>
<div class="component" id="institutes-switcher">
	<h3>YOU ARE EXPLORING</h3>
	<div class="select-wrapper">
		<select class="form-control">
			<?php foreach ($instites as $slug => $title) { ?>
				<option value="<?= $slug ?>"<?= (preg_match("@^research/centers-institutes/$slug(/.*)?$@", $path)) ? ' selected' : '' ?>><?= $title ?></option>
			<?php } ?>
		</select>
	</div>
</div>