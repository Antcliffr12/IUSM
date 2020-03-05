<?php
$department_groups = [
	"Basic Science" => [
		"anatomy-cell-biology" => "Anatomy and Cell Biology",
		"biochemistry-molecular-biology" => "Biochemistry and Molecular Biology",
		"biostatistics" => "Biostatistics",
		"physiology" => "Cellular and Integrative Physiology",
		"genetics" => "Medical and Molecular Genetics",
		"microbiology-immunology" => "Microbiology and Immunology",
		"pathology" => "Pathology and Laboratory Medicine",
		"pharmacology-toxicology" => "Pharmacology and Toxicology",
	],
	"Clinical Science" => [
		"anesthesia" => "Anesthesia",
		"dermatology" => "Dermatology",
		"emergency-medicine" => "Emergency Medicine",
		"family-medicine" => "Family Medicine",
		"internal-medicine" => "Medicine",
		"neurological-surgery" => "Neurological Surgery",
		"neurology" => "Neurology",
		"obgyn" => "Obstetrics and Gynecology",
		"ophthalmology" => "Ophthalmology",
		"orthopaedic-surgery" => "Orthopaedic Surgery",
		"otolaryngology" => "Otolaryngology—Head and Neck Surgery",
		"pediatrics" => "Pediatrics",
		"physiatry" => "Physical Medicine and Rehabilitation",
		"psychiatry" => "Psychiatry",
		"radiology" => "Radiology and Imaging Sciences",
		"radiation-oncology" => "Radiation Oncology",
		"surgery" => "Surgery",
		"urology" => "Urology",
	],
];
?>
<div class="component" id="department-switcher">
	<h3>YOU ARE EXPLORING</h3>
	<div class="select-wrapper">
		<select class="form-control">
			<?php foreach ($department_groups as $optgroup => $opts) { ?>
				<optgroup label="<?= $optgroup ?>">
					<?php foreach ($opts as $slug => $title) { ?>
						<option value="<?= $slug ?>"<?= (preg_match("@^departments/$slug(/.*)?$@", $path)) ? ' selected' : '' ?>><?= $title ?></option>
					<?php } ?>
				</optgroup>
			<?php } ?>
		</select>
	</div>
</div>
