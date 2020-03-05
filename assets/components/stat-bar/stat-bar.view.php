<?php

$animate = $animation_toggle == "true" ? "true" : "false";
$numberOne = isset($column_one_number) ? stat_check_number($column_one_number) : '---';
$numberTwo = isset($column_two_number) ? stat_check_number($column_two_number) : '---';
$numberThree = isset($column_three_number) ? stat_check_number($column_three_number) : '---';
$numberFour = isset($column_four_number) ? stat_check_number($column_four_number) : '---';

$setHeight = $animate == 'true' ? ' style="height:42px"' : '';

$descriptionOne = isset($column_one_description) ? $column_one_description : '';
$descriptionTwo = isset($column_two_description) ? $column_two_description : '';
$descriptionThree = isset($column_three_description) ? $column_three_description : '';
$descriptionFour = isset($column_four_description) ? $column_four_description : '';

$activeColumns = 0;

$activeColumns += ($descriptionOne != '') ? 1 : 0;
$activeColumns += ($descriptionTwo != '') ? 1 : 0;
$activeColumns += ($descriptionThree != '') ? 1 : 0;
$activeColumns += ($descriptionFour != '') ? 1 : 0;

if ($activeColumns == 0) {
  $activeColumns = 1;
}
$span = 12 / $activeColumns;
?>

<div class="stat-bar <?= $bg_color ?>" data-animate-digits="<?= $animate ?>" data-items="<?= $span ?>" data-component="Stat Bar" aria-label="IU School of Medicine Stats.">
  <div class="row-fluid clearfix">

    <?php if ($descriptionOne != '') { ?>
    <div class="col-sm-<?=$span?> item"<?= $fontColor ?> aria-label="<?=$numberOne?> <?= $descriptionOne ?>">
      <div class="digit" aria-label="<?=$numberOne?> <?= $descriptionOne ?>" data-number="<?=$numberOne?>"<?= $setHeight ?>><?= $animate == 'false' ? $numberOne : '' ?></div>
      <div class="information" aria-label="<?=$numberOne?> <?= $descriptionOne ?>"><?= $descriptionOne ?></div>
    </div>
    <?php } ?>
    <?php if ($descriptionTwo != '') { ?>
    <div class="col-sm-<?=$span?> item"<?= $fontColor ?> aria-label="<?=$numberTwo?> <?= $descriptionTwo ?>">
      <div class="digit" aria-label="<?=$numberTwo?> <?= $descriptionTwo ?>" data-number="<?=$numberTwo?>"<?= $setHeight ?>><?= $animate == 'false' ? $numberTwo : ''; ?></div>
      <div class="information" aria-label="<?=$numberTwo?> <?= $descriptionTwo ?>"><?= $descriptionTwo ?></div>
    </div>
    <?php } ?>
    <?php if ($descriptionThree != '') { ?>
    <div class="col-sm-<?=$span?> item"<?= $fontColor ?> aria-label="<?=$numberThree?> <?= $descriptionThree ?>">
      <div class="digit" aria-label="<?=$numberThree?> <?= $descriptionThree ?>" data-number="<?=$numberThree?>"<?= $setHeight ?>><?= $animate == 'false' ? $numberThree : ''; ?></div>
      <div class="information" aria-label="<?=$numberThree?> <?= $descriptionThree ?>"><?= $descriptionThree ?></div>
    </div>
    <?php } ?>
    <?php if ($descriptionFour != '') { ?>
    <div class="col-sm-<?=$span?> item"<?= $fontColor ?> aria-label="<?=$numberFour?> <?= $descriptionFour ?>">
      <div class="digit" aria-label="<?=$numberFour?> <?= $descriptionFour ?>" data-number="<?=$numberFour?>"<?= $setHeight ?>><?= $animate == 'false' ? $numberFour : ''; ?></div>
      <div class="information" aria-label="<?=$numberFour?> <?= $descriptionFour ?>"><?= $descriptionFour ?></div>
    </div>
    <?php } ?>
  </div>
</div>
