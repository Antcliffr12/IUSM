<section id="campuses" data-selectedcampus="Bloomington">
	<div class="container">
		<h2>Campuses</h2>
		<div class="row">

			<div class="col-md-4 campus-links">
				<p>Each IU School of Medicine campus offers a high-quality medical education with an integrated curriculum, access to leading medical research and clinical resources, and a rich campus life.</p>
				<div class="clearfix list-wrapper">
					<?php
					if (has_nav_menu('campuses')) {
						wp_nav_menu( array(
							'theme_location' => 'campuses',
                            'walker' => new split_walker,
						) );
					} else { ?>
						<ul class="menu">
							<li><a class="active" data-campus="Bloomington" href="/education/campuses/bloomington">Bloomington</a></li>
							<li><a data-campus="Evansville" href="/education/campuses/evansville">Evansville</a></li>
							<li><a data-campus="Fort Wayne" href="/education/campuses/fort-wayne">Fort Wayne</a></li>
							<li><a data-campus="Northwest – Gary" href="/education/campuses/gary">Northwest – Gary</a></li>
							<li><a data-campus="Indianapolis" href="/education/campuses/indianapolis">Indianapolis</a></li>
						</ul>
						<ul class="menu">
							<li><a data-campus="Muncie" href="/test/campuses/muncie">Muncie</a></li>
							<li><a data-campus="South Bend" href="/education/campuses/south-bend">South Bend</a></li>
							<li><a data-campus="Terre Haute" href="/education/campuses/terra-haute">Terre Haute</a></li>
							<li><a data-campus="West Lafayette" href="/education/campuses/west-lafayette">West Lafayette</a></li>
						</ul>
					<?php } ?>
				</div>
			</div>

			<div class="col-md-4 campus-map">
				<div class="map-container">
					<img src="<?= THEME_PATH ?>/assets/components/campuses/state-in.png" alt="IUSM Campuses">
					<span class="active" data-campus="Bloomington"></span>
					<span data-campus="Evansville"></span>
					<span data-campus="Fort Wayne"></span>
					<span data-campus="Northwest – Gary"></span>
					<span data-campus="Indianapolis"></span>
					<span data-campus="Muncie"></span>
					<span data-campus="South Bend"></span>
					<span data-campus="Terre Haute"></span>
					<span data-campus="West Lafayette"></span>
				</div>
			</div>

			<div class="col-md-4 campus-detail">
				<div data-campus="Bloomington" class="active">
					<h3>Bloomington Campus Highlights</h3>
					<p>Located on a vibrant campus in the hilly and forested region of southern Indiana, IU School of Medicine-Bloomington offers a diverse range of academic and extra-curricular opportunities, including innovative service-learning experiences within the community, recreational activities and athletics.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="Evansville" class="active">
					<h3>Evansville Campus Highlights</h3>
					<p>With an average class size of just 20 students and a campus known for strong class attendance, IU School of Medicine-Evansville offers a personalized and intimate learning experience for both students and faculty.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="Fort Wayne">
					<h3>Fort Wayne Campus Highlights</h3>
					<p>Offering a four-year medical education in Indiana’s second-largest metropolitan area, students and faculty at the IU School of Medicine Fort Wayne campus benefit from small class sizes and urban amenities within a community that’s rich with medical resources and support.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="Northwest – Gary" class="active">
					<h3>Northwest – Gary Campus Highlights</h3>
					<p>Distinguished by its urban setting and commitment to clinical integration from the first day of classes, IU School of Medicine-Northwest-Gary offers a well-rounded student education experience that focuses on urban care and provides healthcare to underserved populations.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="Indianapolis" class="active">
					<h3>Indianapolis Campus Highlights</h3>
					<p>IU School of Medicine-Indianapolis offers access to and collaboration with some of the nation’s top teaching hospitals and research facilities. Led by outstanding medical education and research experts—many of whom rank among the nation’s best physicians and scientists—this urban campus offers advanced medical education in the heart of one of the most progressive and economically healthy cities in the United States.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="Muncie">
					<h3>Muncie Campus Highlights</h3>
					<p>Through close proximity and partnership with IU Health Ball Memorial Hospital, the Indiana University School of Medicine Muncie campus is well-known for providing students a four-year medical education with early clinical practice and patient involvement.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="South Bend">
					<h3>South Bend Campus Highlights</h3>
					<p>In partnership with the University of Notre Dame, students and an award-winning research-based faculty explore medicine in the midst of discovery about next-generation cures.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="Terre Haute">
					<h3>Terre Haute Campus Highlights</h3>
					<p>Known for its rural medical education program, IU School of Medicine-Terre Haute addresses the increased need for rural physicians to serve communities throughout the state of Indiana and beyond. Students and faculty enjoy inter-professional education in an open environment, flexible teaching methods, extensive hands-on research and clinical opportunities.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
				<div data-campus="West Lafayette">
					<h3>West Lafayette Campus Highlights</h3>
					<p>The IU School of Medicine-West Lafayette campus facilitates especially close-knit relationships between students and faculty through small class sizes and an education environment that combines lecture with independent study and mentor-based learning. Clinical partnerships provide enriching settings for third- and fourth-year clerkships to round out a four-year medical education with support of a strong academic community.</p>
					<ul>
						<li>Small class sizes</li>
						<li>Mature and supportive medical community</li>
						<li>Low cost of living</li>
						<li>Student summer research, clinical programs</li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</section>
