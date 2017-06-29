<?php
App::uses('AppController', 'Controller');

class GoogleAnalyticsController extends AppController {

	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array();
	public $components = array('GoogleAnalytics');	

	private $nameCountry = array(
	        'AF' => 'Afghanistan',
	        'AX' => 'Aland Islands',
	        'AL' => 'Albania',
	        'DZ' => 'Algeria',
	        'AS' => 'American Samoa',
	        'AD' => 'Andorra',
	        'AO' => 'Angola',
	        'AI' => 'Anguilla',
	        'AQ' => 'Antarctica',
	        'AG' => 'Antigua and Barbuda',
	        'AR' => 'Argentina',
	        'AM' => 'Armenia',
	        'AW' => 'Aruba',
	        'AU' => 'Australia',
	        'AT' => 'Austria',
	        'AZ' => 'Azerbaijan',
	        'BS' => 'Bahamas the',
	        'BH' => 'Bahrain',
	        'BD' => 'Bangladesh',
	        'BB' => 'Barbados',
	        'BY' => 'Belarus',
	        'BE' => 'Belgium',
	        'BZ' => 'Belize',
	        'BJ' => 'Benin',
	        'BM' => 'Bermuda',
	        'BT' => 'Bhutan',
	        'BO' => 'Bolivia',
	        'BA' => 'Bosnia and Herzegovina',
	        'BW' => 'Botswana',
	        'BV' => 'Bouvet Island (Bouvetoya)',
	        'BR' => 'Brazil',
	        'IO' => 'British Indian Ocean Territory',
	        'VG' => 'British Virgin Islands',
	        'BN' => 'Brunei Darussalam',
	        'BG' => 'Bulgaria',
	        'BF' => 'Burkina Faso',
	        'BI' => 'Burundi',
	        'KH' => 'Cambodia',
	        'CM' => 'Cameroon',
	        'CA' => 'Canada',
	        'CV' => 'Cape Verde',
	        'KY' => 'Cayman Islands',
	        'CF' => 'Central African Republic',
	        'TD' => 'Chad',
	        'CL' => 'Chile',
	        'CN' => 'China',
	        'CX' => 'Christmas Island',
	        'CC' => 'Cocos (Keeling) Islands',
	        'CO' => 'Colombia',
	        'KM' => 'Comoros the',
	        'CD' => 'Congo',
	        'CG' => 'Congo the',
	        'CK' => 'Cook Islands',
	        'CR' => 'Costa Rica',
	        'CI' => 'Cote d`Ivoire',
	        'HR' => 'Croatia',
	        'CU' => 'Cuba',
	        'CY' => 'Cyprus',
	        'CZ' => 'Czech Republic',
	        'DK' => 'Denmark',
	        'DJ' => 'Djibouti',
	        'DM' => 'Dominica',
	        'DO' => 'Dominican Republic',
	        'EC' => 'Ecuador',
	        'EG' => 'Egypt',
	        'SV' => 'El Salvador',
	        'GQ' => 'Equatorial Guinea',
	        'ER' => 'Eritrea',
	        'EE' => 'Estonia',
	        'ET' => 'Ethiopia',
	        'FO' => 'Faroe Islands',
	        'FK' => 'Falkland Islands (Malvinas)',
	        'FJ' => 'Fiji the Fiji Islands',
	        'FI' => 'Finland',
	        'FR' => 'France',
	        'GF' => 'French Guiana',
	        'PF' => 'French Polynesia',
	        'TF' => 'French Southern Territories',
	        'GA' => 'Gabon',
	        'GM' => 'Gambia the',
	        'GE' => 'Georgia',
	        'DE' => 'Germany',
	        'GH' => 'Ghana',
	        'GI' => 'Gibraltar',
	        'GR' => 'Greece',
	        'GL' => 'Greenland',
	        'GD' => 'Grenada',
	        'GP' => 'Guadeloupe',
	        'GU' => 'Guam',
	        'GT' => 'Guatemala',
	        'GG' => 'Guernsey',
	        'GN' => 'Guinea',
	        'GW' => 'Guinea-Bissau',
	        'GY' => 'Guyana',
	        'HT' => 'Haiti',
	        'HM' => 'Heard Island and McDonald Islands',
	        'VA' => 'Holy See',
	        'HN' => 'Honduras',
	        'HK' => 'Hong Kong',
	        'HU' => 'Hungary',
	        'IS' => 'Iceland',
	        'IN' => 'India',
	        'ID' => 'Indonesia',
	        'IR' => 'Iran',
	        'IQ' => 'Iraq',
	        'IE' => 'Ireland',
	        'IM' => 'Isle of Man',
	        'IL' => 'Israel',
	        'IT' => 'Italy',
	        'JM' => 'Jamaica',
	        'JP' => 'Japan',
	        'JE' => 'Jersey',
	        'JO' => 'Jordan',
	        'KZ' => 'Kazakhstan',
	        'KE' => 'Kenya',
	        'KI' => 'Kiribati',
	        'KP' => 'Korea',
	        'KR' => 'Korea',
	        'KW' => 'Kuwait',
	        'KG' => 'Kyrgyz Republic',
	        'LA' => 'Lao',
	        'LV' => 'Latvia',
	        'LB' => 'Lebanon',
	        'LS' => 'Lesotho',
	        'LR' => 'Liberia',
	        'LY' => 'Libyan Arab Jamahiriya',
	        'LI' => 'Liechtenstein',
	        'LT' => 'Lithuania',
	        'LU' => 'Luxembourg',
	        'MO' => 'Macao',
	        'MK' => 'Macedonia',
	        'MG' => 'Madagascar',
	        'MW' => 'Malawi',
	        'MY' => 'Malaysia',
	        'MV' => 'Maldives',
	        'ML' => 'Mali',
	        'MT' => 'Malta',
	        'MH' => 'Marshall Islands',
	        'MQ' => 'Martinique',
	        'MR' => 'Mauritania',
	        'MU' => 'Mauritius',
	        'YT' => 'Mayotte',
	        'MX' => 'Mexico',
	        'FM' => 'Micronesia',
	        'MD' => 'Moldova',
	        'MC' => 'Monaco',
	        'MN' => 'Mongolia',
	        'ME' => 'Montenegro',
	        'MS' => 'Montserrat',
	        'MA' => 'Morocco',
	        'MZ' => 'Mozambique',
	        'MM' => 'Myanmar',
	        'NA' => 'Namibia',
	        'NR' => 'Nauru',
	        'NP' => 'Nepal',
	        'AN' => 'Netherlands Antilles',
	        'NL' => 'Netherlands the',
	        'NC' => 'New Caledonia',
	        'NZ' => 'New Zealand',
	        'NI' => 'Nicaragua',
	        'NE' => 'Niger',
	        'NG' => 'Nigeria',
	        'NU' => 'Niue',
	        'NF' => 'Norfolk Island',
	        'MP' => 'Northern Mariana Islands',
	        'NO' => 'Norway',
	        'OM' => 'Oman',
	        'PK' => 'Pakistan',
	        'PW' => 'Palau',
	        'PS' => 'Palestinian Territory',
	        'PA' => 'Panama',
	        'PG' => 'Papua New Guinea',
	        'PY' => 'Paraguay',
	        'PE' => 'Peru',
	        'PH' => 'Philippines',
	        'PN' => 'Pitcairn Islands',
	        'PL' => 'Poland',
	        'PT' => 'Portugal => Portuguese Republic',
	        'PR' => 'Puerto Rico',
	        'QA' => 'Qatar',
	        'RE' => 'Reunion',
	        'RO' => 'Romania',
	        'RU' => 'Russian Federation',
	        'RW' => 'Rwanda',
	        'BL' => 'Saint Barthelemy',
	        'SH' => 'Saint Helena',
	        'KN' => 'Saint Kitts and Nevis',
	        'LC' => 'Saint Lucia',
	        'MF' => 'Saint Martin',
	        'PM' => 'Saint Pierre and Miquelon',
	        'VC' => 'Saint Vincent and the Grenadines',
	        'WS' => 'Samoa',
	        'SM' => 'San Marino',
	        'ST' => 'Sao Tome and Principe',
	        'SA' => 'Saudi Arabia',
	        'SN' => 'Senegal',
	        'RS' => 'Serbia',
	        'SC' => 'Seychelles',
	        'SL' => 'Sierra Leone',
	        'SG' => 'Singapore',
	        'SK' => 'Slovakia',
	        'SI' => 'Slovenia',
	        'SB' => 'Solomon Islands',
	        'SO' => 'Somalia',
	        'ZA' => 'South Africa',
	        'GS' => 'South Georgia and the South Sandwich Islands',
	        'ES' => 'Spain',
	        'LK' => 'Sri Lanka',
	        'SD' => 'Sudan',
	        'SR' => 'Suriname',
	        'SJ' => 'Svalbard & Jan Mayen Islands',
	        'SZ' => 'Swaziland',
	        'SE' => 'Sweden',
	        'CH' => 'Switzerland => Swiss Confederation',
	        'SY' => 'Syrian Arab Republic',
	        'TW' => 'Taiwan',
	        'TJ' => 'Tajikistan',
	        'TZ' => 'Tanzania',
	        'TH' => 'Thailand',
	        'TL' => 'Timor-Leste',
	        'TG' => 'Togo',
	        'TK' => 'Tokelau',
	        'TO' => 'Tonga',
	        'TT' => 'Trinidad and Tobago',
	        'TN' => 'Tunisia',
	        'TR' => 'Turkey',
	        'TM' => 'Turkmenistan',
	        'TC' => 'Turks and Caicos Islands',
	        'TV' => 'Tuvalu',
	        'UG' => 'Uganda',
	        'UA' => 'Ukraine',
	        'AE' => 'United Arab Emirates',
	        'GB' => 'United Kingdom',
	        'US' => 'United States',
	        'UM' => 'United States Minor Outlying Islands',
	        'VI' => 'United States Virgin Islands',
	        'UY' => 'Uruguay, Eastern Republic of',
	        'UZ' => 'Uzbekistan',
	        'VU' => 'Vanuatu',
	        'VE' => 'Venezuela',
	        'VN' => 'Vietnam',
	        'WF' => 'Wallis and Futuna',
	        'EH' => 'Western Sahara',
	        'YE' => 'Yemen',
	        'ZM' => 'Zambia',
	        'ZW' => 'Zimbabwe',
	        'ZZ' => 'Unknown or unspecified country'
	    );

	private $gaData;

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('myajax_sessionschart');			
		$this->Security->unlockedActions =  array('myajax_sessionschart','admin_index');
		
		$gainfo = $this->GoogleAnalytic->find();		
		$this->gaData = $gainfo['GoogleAnalytic'];

	}
    
	
	public function admin_index(){

		$this->layout = 'adminInner';		
		
		if($this->request->is("post") && isset($this->request->data['daterange']) && !empty($this->request->data['daterange'])){			
			$this->Session->write('GoogleAnalytics.daterange',$this->request->data['daterange']);
		}else{
			$this->Session->delete('GoogleAnalytics.daterange');
		}

	}



	public function admin_manage() {
		$this->layout = 'adminInner';

		$client  = $this->GoogleAnalytics->GA();		
		$service = new Google_Service_YouTubeAnalytics($client);
		$authUrl = $client->createAuthUrl();

		

		
		
		$isKeySet = false;

		if(  isset($this->gaData['yt_api_key']) && !empty($this->gaData['yt_api_key'])   &&   isset($this->gaData['yt_client_key']) && !empty($this->gaData['yt_client_key'])   &&   isset($this->gaData['yt_client_secret']) && !empty($this->gaData['yt_client_secret'])	){
			$isKeySet = true;
		}		


		

		if ($this->request->is('post')){

			// if($this->GoogleAnalytic->validates()){
				
				$data = $this->request->data;


				if(isset($data['GoogleAnalytic']['access_code']) && !empty($data['GoogleAnalytic']['access_code'])){

					$client = $this->GoogleAnalytics->GA();
					$service = new Google_Service_Analytics($client);
					$client->authenticate($data['GoogleAnalytic']['access_code']);
					// $client->authenticate('4/o50NeVlCyyTBAVaDCvGcMqNS7ANkZKS0KtDsJNOEywg');		
					$get_token   = json_encode($client->getAccessToken());	
					$data['GoogleAnalytic']['token'] = $get_token;
				}
				
				$this->GoogleAnalytic->save($data);


				if($data['GoogleAnalytic']['phase']=='S'){

					$this->Session->setFlash('<p>Details updated successfully!</p>', 'default', array('class' => 'alert alert-success'));				
					$this->redirect(array('controller'=>'GoogleAnalytics','action'=>'admin_manage'));				

				}else{

					$this->redirect(array('controller'=>'GoogleAnalytics','action'=>'admin_manage'));			

				}
				
			
		}else{
			$this->set('data',array('GoogleAnalytic'=>$this->gaData));
		}

		$this->set('getAccessCodeUrl',$authUrl);
		$this->set('isKeySet',$isKeySet);
	}


	//Ajax
	function myajax_sessionschart(){

		$gacode = $this->gaData['code'];

		$data = array(
			'count_sessions'           => $this->GoogleAnalytics->format_number($this->GoogleAnalytics->CountYT($gacode, 'sessions')),
			'count_users'              => $this->GoogleAnalytics->format_number($this->GoogleAnalytics->CountYT($gacode, 'users')),
			'count_pageviews'          => $this->GoogleAnalytics->format_number($this->GoogleAnalytics->CountYT($gacode, 'pageviews')),

			'count_pages_session'      => round($this->GoogleAnalytics->CountYT($gacode, 'pageviewsPerSession'),2),
			'count_avgSessionDuration' => round($this->GoogleAnalytics->CountYT($gacode, 'avgSessionDuration'),2),
			'count_bounceRate'         => round($this->GoogleAnalytics->CountYT($gacode, 'bounceRate'),2),
			'count_percentNewSessions' => round($this->GoogleAnalytics->CountYT($gacode, 'percentNewSessions'),2),
			'data_sessions'            => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'sessions')),
			'data_users'               => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'users')),
			'data_pageviews'           => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'pageviews')),
			'data_pages_session'       => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'pageviewsPerSession')),
			'data_avgSessionDuration'  => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'avgSessionDuration')),
			'data_bounceRate'          => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'bounceRate')),
			'data_percentNewSessions'  => $this->GoogleAnalytics->chart(array('profileID' => $gacode, 'metrics' => 'percentNewSessions'))
		);	
		
		foreach ($data as $key => $value) {
			$this->set($key,$value);
		}
		
	}
	

}