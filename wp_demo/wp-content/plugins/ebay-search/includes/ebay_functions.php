<?phpfunction sendHttpRequest($xmlrequest, $endpoint, $headers){  $session  = curl_init($endpoint);                       // create a curl session  curl_setopt($session, CURLOPT_POST, true);              // POST request type  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out  $responsexml = curl_exec($session);                     // send the request  curl_close($session);                                   // close the session  return $responsexml;  }function buildXMLFilter($filterarray){  global $xmlfilter;  // Iterate through each filter in the array  foreach ($filterarray as $itemfilter) {    $xmlfilter .= "<itemFilter>\n";    // Iterate through each key in the filter    foreach($itemfilter as $key => $value) {      if(is_array($value)) {        // If value is an array, iterate through each array value        foreach($value as $arrayval) {          $xmlfilter .= " <$key>$arrayval</$key>\n";        }      }      else {        if($value != "") {          $xmlfilter .= " <$key>$value</$key>\n";        }      }    }    $xmlfilter .= "</itemFilter>\n";  }  return "$xmlfilter";}/**	buildEbayHeaders	Generates an array of string to be used as the headers for the HTTP request to eBay	Output:	String Array of Headers*/function buildEbayHeaders($applicationID,$app_version,$siteID, $verb){	$headers = array (		                                "X-EBAY-SOA-OPERATION-NAME: $verb",			"X-EBAY-SOA-SERVICE-VERSION: $app_version",					                "X-EBAY-SOA-REQUEST-DATA-FORMAT: XML",                                "X-EBAY-SOA-GLOBAL-ID:$siteID",		"X-EBAY-SOA-SECURITY-APPNAME:$applicationID",		                                "Content-Type: text/xml;charset=utf-8"        	);	return $headers;}//function to check valid postal and country valuefunction validZip(){        global $items;	if(trim($items['country_name'])=='' || trim($items['reg_country'])==''     		|| (utf8_decode($items['country_name'])=='Deutschland' && strlen($items['postcode'])!=5)     		|| (utf8_decode($items['reg_country'])=='Deutschland' && strlen($items['reg_postalcode'])!=5)    		|| (utf8_decode($items['country_name'])=='�sterreich' && strlen($items['postcode'])!=4)     		|| (utf8_decode($items['reg_country'])=='�sterreich' && strlen($items['reg_postalcode'])!=4)     		|| !validMail($items['email'])    		){    	return false;    }else return true;}//function to check mailfunction validMail($email){	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))		return false;	else return true;}//convert XML to Array conversion function objectsIntoArray($arrObjData, $arrSkipIndices = array()){    $arrData = array();    // if input is object, convert into array    if (is_object($arrObjData)) {        $arrObjData = get_object_vars($arrObjData);    }    if (is_array($arrObjData)) {        foreach ($arrObjData as $index => $value) {            if (is_object($value) || is_array($value)) {                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call            }            if (in_array($index, $arrSkipIndices)) {                continue;            }            $arrData[$index] = $value;        }    }    return $arrData;}?>