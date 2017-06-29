<?php
/*
GoogleAnalyticsComponent
*/
App::uses('Component', 'Controller');

class GoogleAnalyticsComponent extends Component{
	
	private $gaData;

	function __construct(){
		$gaModel = ClassRegistry::init('GoogleAnalytic');
		$gainfo = $gaModel->find();		
		$this->gaData = $gainfo['GoogleAnalytic'];

	}

	function format_number($number = ""){
		return number_format($number, 0, ',',',');
	}


	function filter_input_xss($input){
        if($input)
		  $input= htmlspecialchars($input, ENT_QUOTES);
		return $input;
	}

	function post($input,$check=true){
		//$CI = &get_instance();
		//$CI = $this;
        if($check){
		  //return $this->filter_input_xss($this->post($input));
        	return $this->filter_input_xss($input);
        }else{
            return $this->post($input);
        }
	}

	function get($input){
		$CI = &get_instance();
		return filter_input_xss($CI->input->get($input));
	}	


	
    function CountYT($profileID, $metrics){
    	// echo('pro-'.$profileID);
    	// echo('met-'.$metrics);

        $metrics_temp = $metrics;
        $metrics      = (!empty($metrics))?'ga:'.str_replace(',', ', ga:', $metrics):'';
        $profileID    = "ga:".$profileID;
        $result       = array();
        try{

        	$ga_date = $this->makedate();

        	$from = $ga_date['from'];
	        $to   = $ga_date['to'];
           
            /*
	            $from = date('Y-m-d', strtotime(NOW.' -28 day'));
	            $to   = date('Y-m-d', strtotime(NOW.' -1 day'));


	            if($this->post('daterange'))
	            {

	                $range = explode('-', $this->post('daterange'));
	                $from  = date('Y-m-d', strtotime($range[0]));
	                $to    = date('Y-m-d', strtotime($range[1]));
	            }

	            if(get('daterange'))
	            {
	                $range = explode('-', get('daterange'));
	                $from  = date('Y-m-d', strtotime($range[0]));
	                $to    = date('Y-m-d', strtotime($range[1]));
	            }
            */

            try{
                $service = $this->GAService();
                $data =  $service->data_ga->get($profileID, $from, $to, $metrics);
            } catch (Google_Service_Exception $e) {            	
                return false;
            }

            if (!empty($data)){
                switch ($metrics_temp) {
                    default:
                        $result = $data->rows[0][0];
                        break;
                }
                return $result;
            }else{
                return false;
            }
        } catch (Google_Service_Exception $e) {
            return false;
        }
    }



    function chart($response = array()) {
        $response        = (object)$response;
        $metrics_temp    = (!empty($response->metrics))?$response->metrics:'';
        $dimensions_temp = (!empty($response->dimensions))?$response->dimensions:'';
    	$profileID       = (!empty($response->profileID))?$response->profileID:'';
    	$metrics         = (!empty($response->metrics))?'ga:'.str_replace(',', ', ga:', $response->metrics):'';
    	$dimensions      = (!empty($response->dimensions))?'ga:'.$response->dimensions:'ga:date'; //day
    	$limit           = (isset($response->limit))?$response->limit:0;
        $sort            = (isset($response->sort))?$response->sort:''; //day
    	$filters         = (isset($response->filters))?$response->filters:'';
        $profileID       = 'ga:'.$profileID;

       	
       	$ga_date = $this->makedate();

        $from = $ga_date['from'];
	    $to   = $ga_date['to'];

        /*

        	$from = date('Y-m-d', strtotime(NOW.' -29 day'));
        	$to   = date('Y-m-d', strtotime(NOW.'-1 day'));        


	       if(post('daterange'))
	        {
	            $range = explode('-', post('daterange'));
	            if(count($range) > 1){
	                $from= date('Y-m-d', strtotime($range[0]));
	                $to  = date('Y-m-d', strtotime($range[1]));
	            }
	        }

	        if(get('daterange'))
	        {
	            $range = explode('-', get('daterange'));
	            $from  = date('Y-m-d', strtotime($range[0]));
	            $to    = date('Y-m-d', strtotime($range[1]));
	        }
        */

        $array = array('dimensions' => str_replace("-pie", "", $dimensions));

        if($limit != 0)
            $array['max-results'] = $limit;

        if($sort != '')
            $array['sort'] = $sort;

        if($filters != '')
            $array['filters'] = $filters;

        try{
        	$service = $this->GAService();
            $data =  $service->data_ga->get($profileID, $from, $to, $metrics, $array);
        } catch (Google_Service_Exception $e) {
            return false;
        }

        $yt_dash_statsdata="";
        $dataRow = $data->getRows();
        if(!empty($dataRow)){
        	$result = $data->getRows();
            foreach ($dataRow as $row){
                switch ($dimensions_temp) {
                    case 'userGender':
                        $yt_dash_statsdata.="['".ucfirst($row[0])."',".$row[1]."],";
                        break;
                    case 'userAgeBracket':
                        $yt_dash_statsdata.="['".ucfirst($row[0])."',".$row[1]."],";
                        break;
                    case 'userType':
                        $yt_dash_statsdata.="['".ucfirst($row[0])."',".$row[1]."],";
                        break;
                    case 'countryIsoCode':
                        $yt_dash_statsdata.="{'code' : '".$row[0]."', 'name' : '".$this->nameCountry($row[0])."', 'value' : ".$row[1]."},";
                        break;
                    case 'channelGrouping':
                        $yt_dash_statsdata.="['".ucfirst($row[0])."',".$row[1]."],";
                        break;
                    default:
                        $year  = date("Y", strtotime($row[0]));
                        $month = date("n", strtotime($row[0])) - 1;
                        $day   = date("j", strtotime($row[0]));
                        switch ($metrics_temp) {
                            default:
                                $yt_dash_statsdata.="[Date.UTC(".$year.",".$month.",".$day."),".round($row[1],2)."],";
                                break;
                        }
                        break;
                }
            }
        }else{
            $yt_dash_statsdata.="['0',0],";
        }

        return substr($yt_dash_statsdata, 0, -1);
    }


    function GAService(){
        $token = json_decode($this->gaData['token']);
		if($token){
			$client = $this->GA();
			$service = new Google_Service_Analytics($client);
			$client->setAccessToken($token);
			return $service;
		}else{
			return false;
		}
	}

	function GA(){
        // require_once APPPATH.'libraries/Google/autoload.php';        
        require_once 'google-api-php-client/src/Google/autoload.php';
        
        $client = new Google_Client();
        $client->setAccessType('offline');
        $client->setApplicationName('YouTube Analytics Dashboard');
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
        
        $client->setClientId($this->gaData['yt_client_key']);
        $client->setClientSecret($this->gaData['yt_client_secret']);
        $client->setDeveloperKey($this->gaData['yt_api_key']);
        
        $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
        
        return $client;
	}


	function table_chart($response = array()){
        $response        = (object)$response;
        $metrics_temp    = (!empty($response->metrics))?$response->metrics:'';
        $dimensions_temp = (!empty($response->dimensions))?$response->dimensions:'';
        $profileID       = (!empty($response->profileID))?$response->profileID:'';
        $metrics         = (!empty($response->metrics))?'ga:'.str_replace(',', ', ga:', $response->metrics):'';
        $dimensions      = (!empty($response->dimensions))?'ga:'.$response->dimensions:'ga:date'; //day
        $limit           = (isset($response->limit))?$response->limit:0;
        $sort            = (isset($response->sort))?$response->sort:''; //day
        $filters         = (isset($response->filters))?$response->filters:'';
        $profileID       = 'ga:'.$profileID;


        $ga_date = $this->makedate();

       	$from = $ga_date['from'];
        $to   = $ga_date['to'];

        /*
	        $from = date('Y-m-d', strtotime(NOW.' -28 day'));
	        $to   = date('Y-m-d', strtotime(NOW.'-1 day'));
	       
	        
	        if(post('daterange'))
	        {
	            $range = explode('-', post('daterange'));
	            if(count($range) > 1 && date('Y-m-d', strtotime(NOW)) != date('Y-m-d', strtotime($range[1])) ){
	                $from= date('Y-m-d', strtotime($range[0]));
	                $to  = date('Y-m-d', strtotime($range[1]));
	            }
	        }

	        if(get('daterange'))
	        {
	            $range = explode('-', get('daterange'));
	            $from  = date('Y-m-d', strtotime($range[0]));
	            $to    = date('Y-m-d', strtotime($range[1]));
	        }
        */

        $array = array('dimensions' => str_replace("-pie", "", $dimensions));

        if($limit != 0)
            $array['max-results'] = $limit;

        if($sort != '')
            $array['sort'] = $sort;

        if($filters != '')
            $array['filters'] = $filters;

        try{
            $service = $this->GAService();
            $data =  $service->data_ga->get($profileID, $from, $to, $metrics, $array);
        } catch (Google_Service_Exception $e) {
            return false;
        }

        $dataRow = $data->getRows();
        $yt_dash_statsdata=array();
        if(!empty($dataRow)){
            $result = $data->getRows();
            foreach ($dataRow as $row){
                switch ($dimensions_temp) {
                    default:
                        $yt_dash_statsdata[] = $row;
                        break;
                }
            }
        }

        return $yt_dash_statsdata;
    }

    function nameCountry($key){
	    $data = array(
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

	    if(!empty($data[$key])){
	        return $data[$key];
	    }else{
	        return $key;
	    }
	}


	/*--PRI:this is for date filter--*/
	function makedate(){
		
		$date_range = CakeSession::read('GoogleAnalytics.daterange');
		$date_return = array();

		if(!empty($date_range)){

			$range = explode('-', $date_range);
            $date_return['from']  = date('Y-m-d', strtotime($range[0]));
            $date_return['to']    = date('Y-m-d', strtotime($range[1]));

		}else{			
            $date_return['from'] = date('Y-m-d', strtotime(NOW.' -28 day'));
            $date_return['to'] = date('Y-m-d', strtotime(NOW.' -1 day'));

		}

		return $date_return;
		
	}
	

}