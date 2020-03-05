<?php

namespace IU;

/**
 *
 */
class ResidentData
{

	public $mock = false;
	public $uid;
	public $high_degree = '';
    public $pid;
	public $display_name = '';
	public $first_name = '';
	public $last_name = '';
	public $middle_name = '';
	public $status = '';
	public $utype = '';
	public $username = '';
	public $phone = '';
	public $fax = '';
	public $email = '';
    public $addressOne = '';
    public $addressTwo = '';
    public $city = '';
    public $state = '';
    public $zipcode = '';
	public $trainingDesc = '';
	public $positions = '';
	public $fromSchool = '';
	public $dept_code = '';
	public $dept_desc = '';
	public $expertise = '';
	public $bio = '';
	public $has_photo = 0;
	public $has_cv = 0;
	public $clinical_interests = '';
	public $research_interests = '';
	public $link_publications = '';
	public $link_iuprofile;
	public $link_publications2 = '';
	public $degrees = array();
	public $iu_health;
	public $pubmed = '';
	public $reSearchConnect = '';
	public $leader = NULL;
	/**
	 *
	 */
	public function __construct($pid)
	{
		if (empty($pid)) {
			$pid = -1;
			$this->mock = true;
		}
		$this->pid = $pid;

		$q = <<<EOQ
SELECT TOP 1
        fc.Prsn_Univ_Id AS uid,
        fc.PersonId as pid,
        fc.FullName AS display_name,
        fc.FirstName AS first_name,
        fc.LastName AS last_name,
        fc.MiddleName AS middle_name,
        fc.PersonStatus AS status,
        fc.PersonType AS utype,
        fc.UserName AS username,
        fc.PhoneNumber AS phone,
        fc.Fax AS fax,
        fc.EmailAddress AS email,
        fc.Address1 as addressOne,
        fc.Address2 as addressTwo,
        fc.City as city,
        fc.StateProvinceCode as state,
        fc.ZipCode as zipcode,

		fc.TrainingPrgDescr + ', PGY ' + pgy AS trainingDesc,
		fc.fromSchool,

		fc.high_DegreeCd as highDegree,

		fc.Position_Title AS positions,
        fc.Job_DepartmentCode AS dept_code,
        fc.Job_DepartmentDescr AS dept_desc,
		fc.IUHealthId AS iu_health,
        fb.Expertise AS expertise,
        cast(fb.Bio as text) AS bio,
        (CASE WHEN fb.CV IS NULL THEN 0 ELSE 1 END) AS has_cv,
        (CASE WHEN fb.ProfileImage IS NULL THEN 0 ELSE 1 END) AS has_photo,
        fb.ClinicalInterests AS clinical_interests,
        fb.ResearchInterests AS research_interests,
        fb.UDF1 AS link_publications,
        fb.UDF2 AS link_iuprofile,
        fb.UDF3 AS link_publications2,
		cast(fb.KeyPublications as text) AS key_publications,
		cast(fb.PubMedURL as text) AS pubmed,
		cast(fb.ResearchConnectURL as text) AS reSearchConnect
FROM vwSec_LearnerCore fc
LEFT JOIN vwSec_FacultyBio fb ON fc.PersonId = fb.PersonId
WHERE fc.PersonId = '{$this->pid}'
EOQ;
		$result = (!$this->mock) ? self::query($q) : [self::getMockProfileRow()];

		// Check if there were any records
		if (count($result) === 0) {
			throw new \Exception("PROFILE_NOT_FOUND (pid: $pid)");
		}

		$fields = (object) $result[0];

		$this->uid = $fields->uid;
    $this->pid = $fields->pid;
		$this->highDegree = $fields->highDegree;
		$this->display_name = $fields->display_name;
		$this->first_name = $fields->first_name;
		$this->last_name = $fields->last_name;
		$this->middle_name = $fields->middle_name;
		$this->status = $fields->status;
		$this->utype = $fields->utype;
		$this->username = $fields->username;
		$this->phone = $fields->phone;
		$this->fax = $fields->fax;
		$this->email = $fields->email;
    $this->addressOne = $fields->addressOne;
    $this->addressTwo = $fields->addressTwo;
    $this->city = $fields->city;
    $this->state = $fields->state;
    $this->zipcode = $fields->zipcode;
		$this->trainingDesc = $fields->trainingDesc;
		$this->fromSchool = $fields->fromSchool;
		$this->positions = $fields->positions;
		$this->dept_code = $fields->dept_code;
		$this->dept_desc = $fields->dept_desc;
		$this->iu_health = $fields->iu_health;
		$this->expertise = $fields->expertise;
		$this->bio = $fields->bio;
		$this->has_photo = $fields->has_photo;
		$this->has_cv = $fields->has_cv;
		$this->clinical_interests = $fields->clinical_interests;
		$this->research_interests = $fields->research_interests;
		$this->link_publications = $fields->link_publications;
		$this->link_iuprofile = $fields->link_iuprofile;
		$this->link_publications2 = $fields->link_publications2;
		$this->key_publications = $fields->key_publications;
		$this->pubmed = $fields->pubmed;
		$this->reSearchConnect = $fields->reSearchConnect;

		// Education degree(s)
		if (!$this->mock) {
			$queryDegree = self::query("SELECT TOP(1) DisplayWebDegree FROM vwSec_FacultyEducation WHERE Prsn_Univ_Id = '{$this->uid}' ORDER BY HighestDegree DESC, DegreeRank ASC");
			foreach ($queryDegree as $item) {
				$this->degrees[] = $item['DisplayWebDegree'];
			}
		} else {
			$this->degrees = ['MD', 'MBA'];
		}

		// Executive team
		if (!$this->mock) {
			$queryExecutive = self::query("SELECT TOP(1) FullName FROM vwSec_ExecutiveLeaders WHERE Prsn_Univ_Id = '{$this->uid}'");
			foreach ($queryExecutive as $lead) {
				$this->leader = $lead['FullName'];
			}
		} else {
			$this->leader = NULL;
		}

		return $this;
	}

	public static function getDepartments()
	{
		return self::query('SELECT DISTINCT Job_DepartmentCode AS dept_code, Job_DepartmentDescr AS dept_desc FROM vwSec_FacultyCore ORDER BY Job_DepartmentDescr ASC');
	}


	/**
	 * Faculty Leader
	 */

	public static function getExecutiveLeader($pid)
	{
		if (empty($pid)) {
			$pid = -1;
			$this->mock = true;
		}
		$this->pid = $pid;

		$odbc_conn = odbc_connect($_SERVER['DNS_NAME'], $_SERVER['HR_DB_USER'], $_SERVER['HR_DB_PASSWORD']);



		$con = odbc_connect("DRIVER={Easysoft ODBC-SQL Server};Server=192.0.2.1:1433;Database=MyCyrillicDB;Client_CSet=UTF-8;" .
                    "Server_CSet=Windows-1251", "sa", "easysoft");


		$data = array();
		$q = <<<EOQ
SELECT
        DISTINCT el.Prsn_Univ_Id AS uid,
        el.PersonId AS pid,
        el.FullName AS display_name,
        el.FirstName AS first_name,
        el.LastName AS last_name,
        el.MiddleName AS middle_name,
        el.PersonStatus AS status,
        el.PersonType AS utype,
        el.UserName AS username,
        el.PhoneNumber AS phone,
        el.Fax AS fax,
        el.EmailAddress AS email,
        el.Position_Title AS positions,
        el.Job_DepartmentCode AS dept_code,
        el.Job_DepartmentDescr AS dept_desc
FROM vwSec_ExecutiveLeaders el
WHERE el.Prsn_Univ_Id = '{$this->pid}'
EOQ;

		$data = self::query($q);

		return $data;
	}

	/**
	 * Faculty Leaders
	 */

	public static function getExecutiveList()
	{
		$odbc_conn = odbc_connect($_SERVER['DNS_NAME'], $_SERVER['HR_DB_USER'], $_SERVER['HR_DB_PASSWORD']);
		$data = array();
		$q = <<<EOQ
SELECT
        DISTINCT el.Prsn_Univ_Id AS uid,
        el.PersonId AS pid,
        el.FullName AS display_name,
        el.FirstName AS first_name,
        el.LastName AS last_name,
        el.MiddleName AS middle_name,
        el.PersonStatus AS status,
        el.PersonType AS utype,
        el.UserName AS username,
        el.PhoneNumber AS phone,
        el.Fax AS fax,
        el.EmailAddress AS email,
        el.Position_Title AS positions,
        el.Job_DepartmentCode AS dept_code,
        el.Job_DepartmentDescr AS dept_desc
FROM vwSec_ExecutiveLeaders el
ORDER BY el.LastName, el.FirstName
EOQ;

		$results = self::query($q);

		if (count($results) === 0) {
			throw new \Exception('No leaders found.');
		} else {

			foreach ($results as $row) {

				//education degree
				$qe = "SELECT Top(1) DisplayWebDegree FROM vwSec_FacultyEducation WHERE Prsn_Univ_Id = '" . $row['uid'] . "' ORDER BY HighestDegree DESC, DegreeRank ASC";
				$queryEducation = odbc_exec($odbc_conn, $qe);

				$degrees = [];

				while ($rowEducation = odbc_fetch_array($queryEducation)) {
					$degrees[] = $rowEducation['DisplayWebDegree'];
				}

				$row['degrees'] = $degrees;
				$data[] = $row;
			}
		}
		return $data;
	}

	/**
	 * @param $department_code The string representing the department's identifier code
	 * @return array A list of faculty members
	 * @throws Exception
	 */
	public static function getListByDepartment($department_code, $category = 1)
	{
		$odbc_conn = odbc_connect($_SERVER['DNS_NAME'], $_SERVER['HR_DB_USER'], $_SERVER['HR_DB_PASSWORD']);
		$data = array();
		if ($category == 0) {
			$cond = 'fl.PRIMARY_FACULTY = 1';
		} else {
			$cond = 'fl.Volunteer = 0';
		}
		$q = <<<EOQ
SELECT
        DISTINCT fc.Prsn_Univ_Id AS uid,
        fc.PersonId AS pid,
        fc.FullName AS display_name,
        fc.FirstName AS first_name,
        fc.LastName AS last_name,
        fc.MiddleName AS middle_name,
        fc.PersonStatus AS status,
        fc.PersonType AS utype,
        fc.UserName AS username,
        fc.PhoneNumber AS phone,
        fc.Fax AS fax,
        fc.EmailAddress AS email,
        fc.Position_Title AS positions,
        fc.Job_DepartmentCode AS dept_code,
        fc.Job_DepartmentDescr AS dept_desc
FROM vwSec_FacultyCore fc
JOIN vwSec_FacultyListings fl ON fc.Prsn_Univ_Id = fl.Prsn_Univ_Id
WHERE fl.PRIMARY_FACULTY = 1 AND fl.ACAD_TTL_DEPT_ID = '{$department_code}' AND fl.PRSN_STAT_CD = 'A'
ORDER BY fc.LastName, fc.FirstName
EOQ;

		$results = self::query($q);

		if (count($results) === 0) {
			throw new \Exception('No faculty found for the specified department.');
		} else {

			foreach ($results as $row) {

				//education degree
				$qe = "SELECT Top(1) DisplayWebDegree FROM vwSec_FacultyEducation WHERE Prsn_Univ_Id = '" . $row['uid'] . "' ORDER BY HighestDegree DESC, DegreeRank ASC";
				$queryEducation = odbc_exec($odbc_conn, $qe);

				$degrees = [];

				while ($rowEducation = odbc_fetch_array($queryEducation)) {
					$degrees[] = $rowEducation['DisplayWebDegree'];
				}

				$row['degrees'] = $degrees;
				$data[] = $row;
			}
		}
		return $data;
	}

	/**
	 * @return array List of publications for the faculty member
	 */
	public function getPublicationData($mock = false)
	{
		$q = <<<EOQ
SELECT
URL AS url,
Title AS title,
AuthorList AS authors,
PublicationDate AS pub_date,
Source AS source_abbr,
FullJournalName AS source_full,
Abstract AS abstract
FROM vwSec_Publications
WHERE Prsn_Univ_Id = '{$this->uid}'
ORDER BY PublicationDate DESC
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [[
           'url' => 'http://paywall.me/124115a',
           'title' => 'Effects of Placeholder Data on Rat Populations vs. Placebo',
           'authors' => 'John Doe MD, Rajesh Chandresekar MD',
           'pub_date' => '5/16/2007',
           'source_abbr' => 'JRNLINTSTF',
           'source_full' => 'Journal of Interesting Stuff',
           'abstract' => 'Soo, yeah. Here\'s the thing. This article does not actually exist.',
		]];
	}

	/**
	 * @return array List of previous educational history
	 */
	public function getEducationData($mock = false)
	{
		$q = <<<EOQ
SELECT
Degree AS degree,
DegreeMajorDescription AS degree_description,
DATEDIFF(SECOND, '1970-01-01', DegreeReceivedDate) AS date_awarded,
DegreeSchool AS institution,
DegreeRank AS rank,
HighestDegree AS is_highest_degree
FROM vwSec_FacultyEducation
WHERE Prsn_Univ_Id = '{$this->uid}'
ORDER BY DegreeReceivedDate DESC
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [
			[
				'degree' => 'MD',
				'degree_description' => 'Medical Doctor',
				'date_awarded' => '2005-02-01',
				'institution' => 'Indiana University School of Medicine',
				'is_highest_degree' => 1,
            ],
			[
				'degree' => 'MBA',
				'degree_description' => 'Master of Business Administration',
				'date_awarded' => '2002-01-06',
				'institution' => 'Harvard School of Business',
				'is_highest_degree' => 0,
			],
		];
	}

	/**
	 * @return array ???
	 */
	public function getResearchData($mock = false)
	{
		$q = <<<EOQ
        SELECT
        CAST(fb.ResearchInterests as TEXT) as research
        FROM vwSec_FacultyBio fb
        JOIN vwSec_FacultyCore fc ON fc.PersonId = fb.PersonId
        WHERE fc.PersonId = '{$this->pid}'
        AND fb.ResearchInterests IS NOT NULL
        AND fb.ResearchInterests <> ''
EOQ;
		//return (!$this->mock && !$mock) ? self::query($q) : [];
		return self::query($q);
	}

	public function getExpertiseData($mock = false)
	{
		$q = <<<EOQ
        SELECT
        Tag
        FROM vwSec_ExpertiseTags
        WHERE PersonId = '{$this->pid}'

EOQ;
		return self::query($q);
	}


    public function getServiceData($mock = false)
    {
        $q = <<<EOQ
        SELECT
        CAST(fb.CommunityService as TEXT) as service
        FROM vwSec_FacultyBio fb
        JOIN vwSec_FacultyCore fc ON fc.PersonId = fb.PersonId
        WHERE fc.PersonId = '{$this->pid}'
        AND fb.CommunityService IS NOT NULL
        AND fb.CommunityService <> ''
EOQ;
        //return (!$this->mock && !$mock) ? self::query($q) : [];
        return self::query($q);
    }


	/**
	 * @return array A list of courses
	 */
	public function getTeachingData($mock = false)
	{
		$q = <<<EOQ
                SELECT
                CourseNumber AS course_number,
                SectionNumber AS section_number,
                Semester AS semester,
                Instructor AS instructor,
                CourseType AS course_type,
                CourseTitle AS title,
                CourseSubject AS subject,
                CourseLab AS lab,
                UDF1 AS desc_1,
                UDF2 AS desc_2,
                UDF3 AS desc_3
                FROM vwSec_FacultyTeaching
                WHERE IsDeleted = 0 AND Prsn_Univ_Id = '{$this->uid}'
                ORDER BY CourseNumber
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [];
	}

	public function getMediaData($mock = false)
	{
		$q = <<<EOQ
                SELECT
                MediaType AS media_type,
                MediaTitle AS title,
                MediaArticle AS body,
                MediaURL AS url,
                cast(MediaDate as date) AS pub_date,
                Code AS code
                FROM vwSec_FacultyMedia
                WHERE IsDeleted = 0 AND Prsn_Univ_Id = '{$this->uid}'
                ORDER BY MediaDate DESC
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [];
	}

	public function getEventData($mock = false)
	{
		$q = <<<EOQ
            SELECT
            EventTitle AS title,
            EventDescription AS description,
            StartDateTime AS starts,
            EndDateTime AS ends,
            Location AS location
            FROM vwSec_FacultyEvent
            WHERE IsDeleted = 0 AND Prsn_Univ_id = '{$this->uid}'
            ORDER BY StartDateTime ASC
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [];
	}

	public function getAwardsData($mock = false)
	{
		$q = <<<EOQ
            SELECT
            AwardingOrg AS org,
            cast(AwardDescription as text) AS description,
            cast(AwardDateTime as date) AS awardDate,
            AwardScope AS scope
			FROM vwSec_FacultyAwards
            WHERE IsDeleted = 0 AND Prsn_Univ_id = '{$this->uid}'
            ORDER BY awardDate DESC
EOQ;
		return self::query($q);
	}

	/**
	 * @return array A list of social media profiles for the user
	 */
	public function getSocialMediaData($mock = false)
	{
		$q = <<<EOQ
            SELECT
            SocialType AS type,
            SocialTitle AS title,
            SocialDescription AS description,
            SocialUrl AS url
            FROM vwSec_FacultySocial
            WHERE IsDeleted = 0 AND Prsn_Univ_Id = '{$this->uid}'
            ORDER BY SocialType
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [
		    ['type' => 1259, 'title' => 'Twitter', 'description' => 'Twitter', 'url' => 'https://twitter.com/IUBloomington'],
		    ['type' => 1260, 'title' => 'Facebook', 'description' => 'Facebook', 'url' => 'https://facebook.com/IndianaUniversity'],
		    ['type' => 1261, 'title' => 'Instagram', 'description' => 'Instagram', 'url' => 'https://instagram.com/iubloomington'],
		    ['type' => 1263, 'title' => 'LinkedIn', 'description' => 'LinkedIn', 'url' => 'https://www.linkedin.com/edu/school?id=18342'],
		];
	}

	public function getSocietyData($mock = false)
    {
        $q = <<<EOQ
        SELECT
        CAST(fps.Society as TEXT) as society
        FROM vwSec_FacultyProfSociety fps
        WHERE fps.PersonId = '{$this->pid}'
        AND fps.Society IS NOT NULL
        AND fps.Society <> ''
EOQ;
        //return (!$this->mock && !$mock) ? self::query($q) : [];
        return self::query($q);
    }

	public function getBoardsData($mock = false)
    {
        $q = <<<EOQ
        SELECT
        CAST(fs.Specialty as TEXT) as specialty
        FROM vwSec_FacultySpecialty fs
        WHERE fs.PersonId = '{$this->pid}'
        AND fs.Specialty IS NOT NULL
        AND fs.Specialty <> ''
EOQ;
        //return (!$this->mock && !$mock) ? self::query($q) : [];
        return self::query($q);
    }

	public function getClinicalData($mock = false)
    {
        $q = <<<EOQ
        SELECT
        CAST(fb.ClinicalInterests as TEXT) as clinical
        FROM vwSec_FacultyBio fb
        WHERE fb.PersonId = '{$this->pid}'
        AND fb.ClinicalInterests IS NOT NULL
        AND fb.ClinicalInterests <> ''
EOQ;
        return (!$this->mock && !$mock) ? self::query($q) : [];
    }


	public function getAdditionalTitlesData($mock = false)
	{
		$q = <<<EOQ
            SELECT TitleDescr AS title
            FROM vwSec_FacultyAdditionalTitles
            WHERE IsActive = 1 AND PRSN_UNIV_ID = '{$this->uid}'
            ORDER BY TitleRank ASC
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [
			['title' => 'Chair of the Pritchell-Hardy Tooling Methods Committee'],
		    ['title' => '5-time Employee of the Month Nominee'],
		    ['title' => 'Honorary Member, Mad Scientist Council of America'],
		];
	}

	
	public function getResidentTitle($mock = false){

		$q = <<<EOQ
            SELECT
						TrainingPrgDescr + ', PGY ' + pgy AS trainingDesc,
						fromSchool AS school
						FROM vwSec_LearnerCore
						WHERE PersonId = '{$this->uid}'
            ORDER BY pgy ASC
EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [
			['trainingDesc' => 'PGY 4', 'school' => 'Indiana University'],

		];

	}

	public function getSchool($mock = false){

		$q = <<<EOQ
						SELECT
						fromSchool AS school
						FROM vwSec_LearnerCore
						WHERE PersonId = '{$this->uid}'

EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [
			['school' => 'Indiana University'],

		];

	}


	public function getPersonInterest($mock = false){
		$q = <<<EOQ
						SELECT Interest AS title
						FROM vwSec_PersonInterest
						WHERE IsDeleted = 0 AND Prsn_Univ_Id = '{$this->uid}'
						ORDER BY Interest

EOQ;
		return (!$this->mock && !$mock) ? self::query($q) : [
				['title' => 'Cytopathology'],
				['title' => 'Head and Neck pathology'],

		];

	}






	/**
	 * @param $query SQL to run against the HR database
	 * @return array Result set returned by the query
	 */
	public static function query($query)
	{
		global $hrdb_conn;
		$data = array();

		if (!isset($hrdb_conn)) {
			$hrdb_conn = \odbc_connect($_SERVER['DNS_NAME'], $_SERVER['HR_DB_USER'], $_SERVER['HR_DB_PASSWORD']);
		}
		if (!$hrdb_conn) {
			throw new \Exception('Unable to connect to HR database!');
		}
		$results = \odbc_exec($hrdb_conn, $query) or die('MSSQL error: '.  \odbc_errormsg());
		while ($row = \odbc_fetch_array($results)) {
			$data[] = $row;
		}
		\odbc_free_result($results);
		return $data;
	}

	public static function getMockProfileRow()
	{
		return [
			'display_name' => 'John Doe',
			'first_name' => 'John',
			'last_name' => 'Doe',
			'middle_name' => null,
			'status' => 'Active',
			'utype' => 'A12',
			'username' => 'JDOE',
			'phone' => '(317) 555-1212',
			'fax' => '(317) 555-5555',
			'email' => 'jdoe@iu.edu',
			'positions' => 'Associate Director of Virtual Activities',
			'dept_code' => 'IN-OTHN',
			'dept_desc' => 'OTOLARYNGOLOGY & H/N SURGERY',
			'expertise' => '',
			'bio' => '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p><p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>',
			'has_cv' => 1,
			'has_photo' => 0,
			'clinical_interests' => '',
			'research_interests' => '',
			'link_publications' => '',
			'link_iuprofile' => '',
			'link_publications' => '',
		];
	}

}
