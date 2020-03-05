

<div class="component faculty-list" data-component="Department Faculty List">
	<h2>Faculty Listing</h2>
	<div class="row">
		<?php foreach ($faculty as $row) {

			//Fullname
			$fullname = "{$row['first_name']}".((trim($row['middle_name']) != '')? ' '. substr($row['middle_name'], 0, 1) .'.':'')." {$row['last_name']}".(count($row['degrees']) > 0 ? ", ".$row['degrees'][0] : '');

			// SEO URL name
			$url_name = strtolower(str_replace(' ', '-', "{$row['last_name']}-{$row['first_name']}"));
			$url_name = preg_replace('@[^-a-z]@', '', $url_name);

			// position title
			$positions = explode(';', $row['positions']);
			echo mb_detect_encoding($positions);
			?>
			<div class="faculty-member col-sm-6" data-faculty-id="<?=$row['pid']?>">
				<div class="image">
					<img src="<?=getFacultyImage($row['pid'])?>" alt="<?=$fullname?>">
				</div>
				<div class="text center-contents-vertically">
					<span>
						<h4><a href="<?= $row["pid"] ?>/<?= $url_name ?>/" rel="nofollow"><?= $fullname ?></a></h4>
						<div class="titles">                        							
                            <?= array_shift($positions) ?>
						</div>
					</span>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
