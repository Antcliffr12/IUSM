<div id="campuses" data-selectedcampus="Bloomington" data-component="Campuses">
	<h1><?= $title ?></h1>
	<div class="row">

		<div class="col-md-4 campus-links">
			<div class="intro">
				<?= $intro ?>
			</div>
			<div class="clearfix list-wrapper">
				<?php
				if (has_nav_menu('campuses')) {
					wp_nav_menu( array(
						'theme_location' => 'campuses',
						'walker' => new split_walker,
					) );
				} else { ?>
					<ul class="menu">
						<li><a class="active" data-campus="Bloomington" href="/education/campuses/bloomington" aria-describedby="bloomington">Bloomington</a></li>
						<li><a data-campus="Evansville" href="/education/campuses/evansville" aria-describedby="evansville">Evansville</a></li>
						<li><a data-campus="Fort Wayne" href="/education/campuses/fort-wayne" aria-describedby="fort-wayne">Fort Wayne</a></li>
						<li><a data-campus="Northwest – Gary" href="/education/campuses/gary" aria-describedby="northwest-gary">Northwest – Gary</a></li>
						<li><a data-campus="Indianapolis" href="/education/campuses/indianapolis" aria-describedby="indianapolis">Indianapolis</a></li>
					</ul>
					<ul class="menu">
						<li><a data-campus="Muncie" href="/education/campuses/muncie" aria-describedby="muncie">Muncie</a></li>
						<li><a data-campus="South Bend" href="/education/campuses/south-bend" aria-describedby="south-bend">South Bend</a></li>
						<li><a data-campus="Terre Haute" href="/education/campuses/terra-haute" aria-describedby="terre-haute">Terre Haute</a></li>
						<li><a data-campus="West Lafayette" href="/education/campuses/west-lafayette" aria-describedby="west-lafayette">West Lafayette</a></li>
					</ul>
				<?php } ?>
			</div>
		</div>

		<div class="col-md-4 campus-map" role="presentation">
			<div class="map-container">
				<img src="<?= THEME_PATH ?>/assets/components/campuses/state-in.png" alt="">
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
			<div id="bloomington" data-campus="Bloomington" class="active">
				<h2>Bloomington Campus Highlights</h2>
				<p>The Medical Sciences Program in Bloomington is unique among the IU School of Medicine campuses in that it educates medical students seeking an MD as well as graduate and undergraduate students. Bloomington offers a Big 10 learning environment on an iconic campus.</p>				
			</div>
			<div id="evansville" data-campus="Evansville" class="active">
				<h2>Evansville Campus Highlights</h2>
				<p>With six major hospitals housing about 2000 beds, medical students in Evansville have access to physician educators in a range of medical specialties. An expanded residency program here will provide more than 100 new graduate medical education positions over the next few years.</p>				
			</div>
			<div id="fort-wayne" data-campus="Fort Wayne">
				<h2>Fort Wayne Campus Highlights</h2>
				<p>Among the most appealing aspects of the Fort Wayne campus is free student parking. That’s right; medical students park in any lot or garage here—for free, anytime. This campus also hosts the Student Research Fellowship Program, which offers med students nine weeks of summer research experience.</p>				
			</div>
			<div id="indianapolis" data-campus="Indianapolis" class="active">
				<h2>Indianapolis Campus Highlights</h2>
                <p>Students and faculty in Indianapolis benefit from close proximity to some of Indiana’s largest teaching hospitals and the Richard L. Roudebush Veterans Administration Medical Center. This campus offers medical education in the heart of one of the most progressive and economically healthy cities in the United States.</p>				
			</div>
            <div id="muncie" data-campus="Muncie">
				<h2>Muncie Campus Highlights</h2>
				<p>Muncie is the School’s only campus that’s located on hospital property, giving medical students a front-row four-year medical education with all the amenities that come with being located near the campus of Ball State University, a bustling college environment.</p>				
			</div>
			<div id="gary" data-campus="Northwest – Gary" class="active">
				<h2>Northwest – Gary Campus Highlights</h2>
				<p>Located in a highly populated urban region just 25 miles from downtown Chicago, the Gary campus offers medical students unparalleled access to clinical care at 11 major teaching hospitals housing 2800 beds. An expanded residency program in Gary will accommodate more than 100 new graduate medical education positions.</p>
			</div>			
			<div id="south-bend" data-campus="South Bend">
				<h2>South Bend Campus Highlights</h2>
				<p>IU School of Medicine-South Bend is located on the campus of Notre Dame, offering a rich campus life in a traditionally collegiate community. Students here gain clinical care experience at the Navari Student Outreach Clinic, and external funding for faculty research exceeds $2 million per year.</p>
			</div>
			<div id="terra-haute" data-campus="Terre Haute">
				<h2>Terre Haute Campus Highlights</h2>
				<p>Known for its rural medical education program, IU School of Medicine-Terre Haute meets the increased need for physicians to serve rural communities throughout the state of Indiana and beyond. This unique four-year medical school program emphasizes primary care and other specialties of need in rural communities.</p>
			</div>
			<div id="west-lafayette" data-campus="West Lafayette">
				<h2>West Lafayette Campus Highlights</h2>
				<p>Located on the campus of Purdue University, the West Lafayette campus offers a Big Ten campus atmosphere and opportunities to supplement the MD curriculum with research experience in the collaborative labs and research centers here. This campus offers opportunities for interprofessional education with areas such as pharmacy, nursing and psychology.</p>
			</div>
		</div>
	</div>
</div>
