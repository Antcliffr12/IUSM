<?php

$bio_photo_url = ($profile->has_photo) ? getFacultyImage($profile->pid) : '/wp-content/themes/iusm/assets/images/faculty-placeholder.png';
$positions = explode(';', $profile->positions);

// Load additional related content
$data_tab_publications = $profile->getPublicationData();
$data_tab_education = $profile->getEducationData();
$data_tab_research = $profile->getResearchData();
$data_tab_teaching = $profile->getTeachingData();
$data_tab_media = $profile->getMediaData();
$data_social_media = $profile->getSocialMediaData();
$data_tab_events = $profile->getEventData();
$data_tab_awards = $profile->getAwardsData();
$data_additional_titles = $profile->getAdditionalTitlesData();

$data_tab_society = $profile->getSocietyData();
$data_tab_boards = $profile->getBoardsData();
$data_tab_clinical = $profile->getClinicalData();

$data_tab_expertise = $profile->getExpertiseData();

$data_tab_research = array_unique($profile->getResearchData());
$data_tab_service = array_unique($profile->getServiceData());

$dept_desc = isset($profile->dept_desc) ? $profile->dept_desc : '';
$addressOne = isset($profile->addressOne) ? $profile->addressOne : '';
$addressTwo = isset($profile->addressTwo) ? $profile->addressTwo : '';
$city = isset($profile->city) ? $profile->city : '';
$state = isset($profile->state) ? $profile->state :'';
$zipcode = isset($profile->zipcode) ? $profile->zipcode : '';

// Merge additional titles into position list so we can just list from one collection
foreach ($data_additional_titles as $row) {
	$positions[] = $row['title'];
}

?>

<div class="faculty-profile" data-faculty-id="<?= $profile->pid?>" data-component="Faculty Profile">

	<div class="summary bg-iu-crimson">
		<div class="bio-photo">
			<img src="<?= $bio_photo_url ?>" alt="<?= $fullname ?>">
		</div>
		<div class="text center-contents-vertically">
			<span>
				<h1><?=$title?></h1>
				<div class="positions">
					<h3><?= array_shift($positions) ?></h3>
				</div>
				<?php if ($profile->has_cv) { ?>
					<p><a class="button caret-down-before" href="/faculty-cv.php?fid=<?= $profile->pid ?>">DOWNLOAD CV</a></p>
				<?php } ?>
			</span>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-8">
			<h2>Bio</h2>
            <div>
				<?= $profile->bio ?>
            </div>

			<?php if (!empty($profile->key_publications)) {?>
        	<h2>Key Publications</h2>
            <div>
            	<?= $profile->key_publications ?>
            </div>
            <?php } ?>

        </div>

		<div class="col-lg-4">
			<h2>Connect</h2>
			<div class="contact-info">
				<?php if (!empty($profile->email)) {?><p><label>Email</label><br><a href="mailto:<?=$profile->email?>"><?=$profile->email?></a>&nbsp;</p><?php } ?>
				<?php if (!empty($profile->phone)) {?><p><label>Phone</label><br><a href="tel:<?=$profile->phone?>"><?=$profile->phone?></a>&nbsp;</p><?php } ?>
				<p><label>Address</label><br>
					<?= !empty($dept_desc) ? $dept_desc : '' ?>
                    <br />
					<?= !empty($addressOne) ? $addressOne : '' ?>
					<?= !empty($addressTwo) ? $addressTwo : '' ?>
					<br />
					<?= !empty($city) ? $city . ', ' : '' ?>
					<?= !empty($state) ? $state : '' ?>
					<?= !empty($zipcode) ? $zipcode : '' ?>
				</p>
			</div>
			<?php if (count($data_social_media) > 0) { ?>
				<div class="social-links clearfix">
					<?php foreach($data_social_media as $row) {
						$typeArr = ['1259','1260','1261','1263'];
							if( in_array($row['type'], $typeArr)):
							?>
								<a href="<?= $row['url'] ?>" data-social-type="<?= $row['type'] ?>" title="<?= $row['title'] ?>" aria-label="<?= $row['title'] ?>" target="_blank">&nbsp;</a>
							<?php
							endif;
						}
					?>
				</div>
			<?php } ?>
            <?php if (!empty($profile->pubmed)) { ?>
            	<br />
            	<a href="<?=$profile->pubmed ?>" target="_blank"><img src="/wp-content/themes/iusm/assets/images/pubmed.jpg" /></a>
			<?php } ?>
            &nbsp;&nbsp;
            <?php if (!empty($profile->reSearchConnect)) { ?>
				<a href="<?=$profile->reSearchConnect ?>" target="_blank"><img src="/wp-content/themes/iusm/assets/images/reSearchConnect.jpg" /></a>
			<?php } ?>

			<?php if (count($data_tab_expertise) !== 0) { ?>
				<h2><label>Areas of expertise</label></h2>
				<div>
					<?php foreach ($data_tab_expertise as $row) { ?>
						<span ><?=$row['Tag']?></span><br>
					<?php } ?>
				</div>
			<?php } ?>

		</div>

	</div>

	<div class="row">

		<div class="col-xs-12">

			<?php if (count($positions) > 0) { ?>
			<div class="titles-and-appointments">
				<h2>Titles &amp; Appointments</h2>
				<ul>
					<?php foreach ($positions as $pos) {?>
						<li><?=$pos?></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>

			<div class="panel-group iu-accordion" id="profile-accordion" role="tablist" aria-multiselectable="true" data-component="Accordion">

				<?php if (count($data_tab_education) !== 0) { ?>
				<div class="panel" id="panel-education">
					<div class="panel-heading" role="tab" id="panel-education-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-education-body" aria-expanded="false" class="collapsed" aria-controls="panel-education-body">
								Education
							</a>
						</h4>
					</div>
					<div id="panel-education-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-education-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach ($data_tab_education as $row) { ?>
								<div class="item">
									<span class="year"><?=date('Y', $row['date_awarded'])?></span>
									<span class="degree"><?=$row['degree']?></span>
									<span class="institution"><?=$row['institution']?></span>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if (sizeof($data_tab_research) !== 0) { ?>
				<div class="panel" id="panel-research">
					<div class="panel-heading" role="tab" id="panel-research-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-research-body" aria-expanded="false" class="collapsed" aria-controls="panel-research-body">
								Research
							</a>
						</h4>
					</div>
					<div id="panel-research-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-research-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_research as $row) { ?>
								<?= $row['research'] ?>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if (count($data_tab_publications) !== 0) { ?>
				<div class="panel" id="panel-publications">
					<div class="panel-heading" role="tab" id="panel-publications-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-publications-body" aria-expanded="false" class="collapsed" aria-controls="panel-publications-body">
								Publications
							</a>
						</h4>
					</div>
					<div id="panel-publications-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-publications-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach ($data_tab_publications as $row) { ?>
								<article>
									<h3><a href="<?=$row['url']?>"><?=$row['title']?></a></h3>
									<div>
										<span class="authors"><?=$row['authors']?></span>
										<span class="source"><?=$row['source_full']?>, <?=$row['pub_date']?></span>
									</div>
								</article>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if (count($data_tab_teaching) !== 0) { ?>
				<div class="panel" id="panel-teaching">
					<div class="panel-heading" role="tab" id="panel-teaching-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-teaching-body" aria-expanded="false" class="collapsed" aria-controls="panel-teaching-body">
								Teaching
							</a>
						</h4>
					</div>
					<div id="panel-teaching-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-teaching-heading" aria-expanded="false">
						<div class="panel-body">
							<ul class="colorbullets">
								<?php foreach($data_tab_teaching as $row) { ?>
									<li>
										<h3><?=$row['title']?></h3>
										<div>
                                        	<?php if (isset($row['course_number']) && !empty($row['course_number'])) { ?>
                                            	<strong>Course Number:</strong> <?=$row['course_number']?><br />
                                            <?php } ?>
                                            <?php if (isset($row['semester']) && !empty($row['semester'])) { ?>
                                            	<strong>Semester:</strong> <?=$row['semester']?><br />
                                            <?php } ?>
                                            <?php if (isset($row['course_type']) && !empty($row['course_type'])) { ?>
                                            	<strong>Type:</strong> <?=$row['course_type']?><br />
                                            <?php } ?>
                                            <?php if (isset($row['lab']) && !empty($row['lab'])) { ?>
                                            	<strong>Lab:</strong> <?=$row['lab']?>
                                            <?php } ?>
										</div>
                                       	<?php if (isset($row['desc_1']) && !empty($row['desc_1'])) { ?>
                                            <div class="description">
                                                <?=$row['desc_1']?>
                                            </div>
                                        <?php } else { ?>
                                        	<br />
                                        <?php } ?>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if (sizeof($data_tab_service) !== 0) { ?>
				<div class="panel" id="panel-service">
					<div class="panel-heading" role="tab" id="panel-service-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-service-body" aria-expanded="false" class="collapsed" aria-controls="panel-service-body">
								Service
							</a>
						</h4>
					</div>
					<div id="panel-service-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-service-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_service as $row):?>
								<p><?= strip_tags($row['service']) ?></p>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if (count($data_tab_media) !== 0) { ?>
				<div class="panel" id="panel-media">
					<div class="panel-heading" role="tab" id="panel-media-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-media-body" aria-expanded="false" class="collapsed" aria-controls="panel-media-body">
								Media
							</a>
						</h4>
					</div>
					<div id="panel-media-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-media-heading" aria-expanded="false">
						<div class="panel-body">
							<ul class="colorbullets">
								<?php foreach($data_tab_media as $row) { ?>
									<li>
                                    	<?php if (substr($row['url'], 0, 22) == 'https://medicine.iu.edu') { ?>
										<h3><a href="<?=$row['url']?>"><?=$row['title']?></a></h3>
                                        <?php } else { ?>
                                        <h3><a href="<?=$row['url']?>" target="_blank"><?=$row['title']?></a></h3>
                                        <?php } ?>
										<div>
											<span class="date-published"><?=$row['pub_date']?></span>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>

                <?php if (count($data_tab_society) !== 0) { ?>
				<div class="panel" id="panel-society">
					<div class="panel-heading" role="tab" id="panel-society-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-society-body" aria-expanded="false" class="collapsed" aria-controls="panel-society-body">
								Professional Organizations
							</a>
						</h4>
					</div>
					<div id="panel-society-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-society-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_society as $row):?>
								<?= strip_tags($row['society']) ?><br />
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php } ?>

                <?php if (count($data_tab_boards) !== 0) { ?>
				<div class="panel" id="panel-boards">
					<div class="panel-heading" role="tab" id="panel-boards-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-boards-body" aria-expanded="false" class="collapsed" aria-controls="panel-boards-body">
								Board Certifications
							</a>
						</h4>
					</div>
					<div id="panel-boards-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-boards-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_boards as $row):?>
								<?= strip_tags($row['specialty']) ?><br />
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php } ?>

                <?php if (count($data_tab_clinical) !== 0) { ?>
				<div class="panel" id="panel-clinical">
					<div class="panel-heading" role="tab" id="panel-clinical-heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-clinical-body" aria-expanded="false" class="collapsed" aria-controls="panel-clinical-body">
								Clinical Interests
							</a>
						</h4>
					</div>
					<div id="panel-clinical-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-clinical-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_clinical as $row):?>
								<?= strip_tags($row['clinical']) ?><br />
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php } ?>

				<?php if (count($data_tab_events) !== 0) { ?>
				<div class="panel" id="panel-events">
					<div class="panel-heading" role="tab" id="panel-events-heading">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-events-body" aria-expanded="false" aria-controls="panel-events-body">
								Events
							</a>
						</h4>
					</div>
					<div id="panel-events-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-events-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_events as $row) { ?>
								<div class="event">
									<h3 class="title"><?= $row['title'] ?></h3>
									<div class="info">Starts: <?= $row['starts'] ?> | Ends: <?= $row['ends'] ?> | Location: <?= $row['location'] ?></div>
									<div class="description">
										<?= $row['description'] ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>

                <?php if (count($data_tab_awards) !== 0) { ?>
				<div class="panel" id="panel-awards">
					<div class="panel-heading" role="tab" id="panel-awards-heading">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#panel-awards-body" aria-expanded="false" aria-controls="panel-awards-body">
								Awards
							</a>
						</h4>
					</div>
					<div id="panel-awards-body" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-awards-heading" aria-expanded="false">
						<div class="panel-body">
							<?php foreach($data_tab_awards as $row):
                                $description = strip_tags($row['description']);
                                ?>
                            	<strong>Org:</strong>	<?=$row['org']?><br />
								<strong>Desc:</strong>	<?=strip_tags($row['description'])?><br />
                                <strong>Scope:</strong>	<?=$row['scope']?><br />
                                <strong>Date:</strong>	<?=$row['awardDate']?><br /><br />
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php } ?>

			</div> <!-- /#profile-accordion -->

		</div>

	</div>

</div>
