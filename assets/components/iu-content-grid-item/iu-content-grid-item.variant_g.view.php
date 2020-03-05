<div class="grid-item">

	<?php 
		foreach(array_unique($profile) as $row) {
		
		$fullname = $row['first_name'] . ' ' . $row['last_name'] .(count($row['highDegree'] > 0 ) ? ", ". $row['highDegree'] : '');
		if($row['utype'] == 'Faculty'){
			$url_name = strtolower(str_replace(' ', '-', "{$row['last_name']}-{$row['first_name']}"));
			$url_name = preg_replace('@[^-a-z]@', '', $url_name);
			$url_link = '/faculty/'.$row['pid'].'/'. $url_name .'/';
		}else{
			$url_name = strtolower(str_replace(' ', '-', "{$row['last_name']}-{$row['first_name']}"));
			$url_name = preg_replace('@[^-a-z]@', '', $url_name);
			$url_link = '/resident/'.$row['pid'].'/'. $url_name .'/';
		}
		
		 $positions = explode(';', $row['positions']);
	?>
	<div class="image">
        <img src="<?=getFacultyImage($row['pid'])?>" alt="<?= $fullname ?>">
    </div>
	<h2 class="title">
		<?php if(isset($url_link) && !empty($url_link)) { ?>
		 <a href="<?= $url_link ?>" title="" aria-label="<?= $fullname ?>" ><?= $fullname ?></a>
		<?php } else {
			echo $fullname;
		}
		?>
	 </h2>
	 <div class="subtitle"><?= $positions[0]; ?></div>
	 <div class="description">
		<?= $intro; ?>
	 </div>
	<?php 
		}
	?>
</div>