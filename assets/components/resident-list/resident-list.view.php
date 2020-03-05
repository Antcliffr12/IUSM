

<div class="component faculty-list" data-component="Resident Faculty List">
	<div class="row">
		<?php foreach ($resident as $row) {

			//Fullname
		//	$fullname = "{$row['first_name']}".((trim($row['middle_name']) != '')? ' '. substr($row['middle_name'], 0, 1) .'.':'')." {$row['last_name']}".(count($row['degrees']) > 0 ? ", ".$row['degrees'][0] : '');


			$fullname = $row['first_name'].(isset($row['middle_name'])? ' '.substr($row['middle_name'], 0, 1).'.' :'').' '.$row['last_name'];

			$title = $row['highDegree'];

			// SEO URL name
			$path_prefix = '/resident/';
			$url_name = strtolower(str_replace(' ', '-', "{$row['last_name']}-{$row['first_name']}"));
			$url_name = preg_replace('@[^-a-z]@', '', $url_name);
			$url = "{$path_prefix}{$row["pid"]}/{$url_name}";

			// position title
			$positions = explode(';', $row['trainingDesc']);
			echo mb_detect_encoding($positions);

			// school title
			$school = $row['school'];

			?>

			<div class="faculty-member col-sm-6" data-faculty-id="<?=$row['pid']?>">

				<div class="text center-contents-vertically">
					<span>
						<h4><a href="<?= $url ?>" rel="nofollow"><?= $fullname?>, <?= $title ?></a></h4>
						<div class="titles">
              <?= array_shift($positions) ?>
						</div>
						<div class="school">
							<?= $school ?>
						</div>
					</span>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
