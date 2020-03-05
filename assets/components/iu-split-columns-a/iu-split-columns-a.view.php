
<div class="<?= $css_classes ?>" data-component="Split Columns A">
	<div class="col col-pos-1 col-xs-12 col-sm-8 col-xl-9">
		<?= (!empty($col_1_title)) ? "<h2>{$col_1_title}</h2>" : '' ?>
		<div class="content">
			<?= $col_1_content ?>
		</div>
		<?php if (count($col_1_buttons) > 0) { ?>
			<p class="button-row">
				<?php
				foreach ($col_1_buttons as $button) {
					$buttonLinkTarget = (isset($button['button_link_target']) && !empty($button['button_link_target'])) ? ' target="'. $button['button_link_target']. '"' : '';
					$iuLogo = (isset($button['iu_logo']) && !empty($button['iu_logo'])) ? ' ' .$button['iu_logo'] : '';
				?>
				<a class="button<?= $iuLogo?>" role="button" data-style="default" href="<?= $button['button_link'] ?>"<?= $buttonLinkTarget ?>><?= $button['button_text'] ?></a>
				<?php } ?>
			</p>
		<?php } ?>
	</div>
	<div class="col col-pos-2 col-xs-12 col-sm-4 col-xl-3">
		<?= (!empty($col_2_title)) ? "<h2>{$col_2_title}</h2>" : '' ?>
		<div class="content">
			<?= $col_2_content ?>
		</div>
		<?php if (count($col_2_buttons) > 0) { ?>
			<p class="button-row">
				<?php
				foreach ($col_2_buttons as $button) {
					$buttonLinkTarget = (isset($button['button_link_target']) && !empty($button['button_link_target'])) ? ' target="'. $button['button_link_target']. '"' : '';
					$iuLogo = (isset($button['iu_logo']) && !empty($button['iu_logo'])) ? ' ' .$button['iu_logo'] : '';
				?>
					<a class="button<?= $iuLogo?>" role="button" data-style="default" href="<?= $button['button_link'] ?>"><?= $button['button_text'] ?></a>
				<?php } ?>
			</p>
		<?php } ?>
	</div>
</div>
