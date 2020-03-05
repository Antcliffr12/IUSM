<?php
$titleRefId = isset($titleRefId) ? $titleRefId : '';
?>

<div class="grid-item">
    <div class="image">
        <img src="<?= $image_data['url'] ?>" alt="<?= $title ?>" aria-describedby="<?= $titleRefId ?>">
    </div>
    <article id="<?= $titleRefId ?>">
        <h1 class="title"><?= $title ?></h1>
        <p class="description">
			<?= $intro ?>
        </p>
    </article>
</div>
