<?php
$defaults = [
	'about-section-title' => 'About',
	'about-section-content' => 'Indiana University School of Medicine is the largest medical school in the US and is annually ranked among the top medical schools in the nation. The school offers high-quality medical education, access to leading medical research, and rich campus life in nine Indiana cities, including rural and urban locations recognized for livability.',
	'footer-menu-title' => 'Popular Topics',
	'contact-info-title' => 'Contact',
	'address-one' => 'Indiana University School of Medicine',
	'address-two' => '340 West 10th Street',
	'address-three' => 'Fairbanks Hall, Suite 6200',
	'address-four' => '',
	'city' => 'Indianapolis',
	'state' => 'IN',
	'zip' => '46202-3082',
	'phone' => '317-274-8157',
	'email' => 'iusm@iu.edu',
	'social-media-title' => 'Connect with Us!',
    'facebook-link' => 'https://www.facebook.com/IUMedicine',
	'linkedIn-link' => 'https://www.linkedin.com/edu/school?id=18346',
	'twitter-link' => 'https://twitter.com/#!/iumedschool',
	'instagram-link' => 'https://www.instagram.com/iumedschool',
];

foreach ($defaults as $key => $val) {
	if (!array_key_exists($key, $iusm_config) || empty($iusm_config[$key])) {
		$iusm_config[$key] = $val;
	}
}
