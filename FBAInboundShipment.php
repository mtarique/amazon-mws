<?php  
class FBAInboundShipment{
	/**
	 * [requestURL description]
	 * @return [type] [description]
	 */
	private function GenerateRequestURL($secretkey, $param){
		$url = array();
		foreach ($param as $key => $val) {
		    $key 	= str_replace("%7E", "~", rawurlencode($key));
		    $val 	= str_replace("%7E", "~", rawurlencode($val));
		    $url[] 	= "{$key}={$val}";
		}
		sort($url);

		$arr   = implode('&', $url);

		$sign  = 'GET' . "\n";
		$sign .= 'mws.amazonservices.com' . "\n";
		$sign .= '/FulfillmentInboundShipment/2010-10-01' . "\n";
		$sign .= $arr;

		$signature = hash_hmac("sha256", $sign, $secretkey, true);
		$signature = urlencode(base64_encode($signature));

		$link  = "https://mws.amazonservices.com/FulfillmentInboundShipment/2010-10-01?";
		$link .= $arr . "&Signature=" . $signature;

		return $link;
	}

	/**
	 * [curlRequest description]
	 * @param  [type] $requesturl [description]
	 * @return [type]             [description]
	 */
	public function CurlRequest($requesturl){
		
		// Header
		$header = array('Content-Type: application/xml; charset=utf-8');

		// Start
		$ch = curl_init($requesturl);

		// Options
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PORT, 443);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$curlResponse 	= curl_exec($ch);
		
		// Close 
		curl_close($ch);

		return $curlResponse;
	}

	/**
	 * [ListInboundShipments description]
	 * @param [type] $sellerid     [description]
	 * @param [type] $mwsauthtoken [description]
	 * @param [type] $awsaccesskey [description]
	 * @param [type] $secretkey    [description]
	 * @param [type] $mpid         [description]
	 * @param [type] $shpstatus    [description]
	 */
	public function ListInboundShipments($sellerid, $mwsauthtoken, $awsaccesskey, $secretkey, $shpstatus)
	{
		// Create parameters
		$param = array();
		$param['AWSAccessKeyId']   	= $awsaccesskey;
		$param['Action']           	= 'ListInboundShipments'; 
		$param['MWSAuthToken']	   	= $mwsauthtoken;
		$param['SellerId']        	= $sellerid; 
		$param['SignatureMethod']  	= 'HmacSHA256';  
		$param['SignatureVersion'] 	= '2'; 
		$param['Timestamp']        	= date("c", time());
		$param['Version']          	= '2010-10-01'; 
		/*$param['MarketplaceId.Id.1']= $mpid;*/ 
		$param['ShipmentStatusList.member.1'] = $shpstatus;

		// Generate request url
		$requestURL = $this->GenerateRequestURL($secretkey, $param);

		// Make curl request
		return $this->CurlRequest($requestURL);
	}

	/**
	 * [ListInboundShipmentsByNextToken description]
	 * @param [type] $sellerid     [description]
	 * @param [type] $mwsauthtoken [description]
	 * @param [type] $awsaccesskey [description]
	 * @param [type] $secretkey    [description]
	 * @param [type] $nexttoken    [description]
	 */
	public function ListInboundShipmentsByNextToken($sellerid, $mwsauthtoken, $awsaccesskey, $secretkey, $nexttoken)
	{
		// Create parameters
		$param = array();
		$param['AWSAccessKeyId']   	= $awsaccesskey;
		$param['Action']           	= 'ListInboundShipmentsByNextToken'; 
		$param['MWSAuthToken']	   	= $mwsauthtoken;
		$param['SellerId']        	= $sellerid; 
		$param['SignatureMethod']  	= 'HmacSHA256';  
		$param['SignatureVersion'] 	= '2'; 
		$param['Timestamp']        	= date("c", time());
		$param['Version']          	= '2010-10-01'; 
		$param['NextToken'] 		= $nexttoken;

		// Generate request url
		$requestURL = $this->GenerateRequestURL($secretkey, $param);

		// Make curl request
		return $this->CurlRequest($requestURL);
	}

	/**
	 * [ListInboundShipmentItems description]
	 * @param [type] $sellerid     [description]
	 * @param [type] $mwsauthtoken [description]
	 * @param [type] $awsaccesskey [description]
	 * @param [type] $secretkey    [description]
	 * @param [type] $nexttoken    [description]
	 */
	public function ListInboundShipmentItems($sellerid, $mwsauthtoken, $awsaccesskey, $secretkey, $shpid)
	{
		// Create parameters
		$param = array();
		$param['AWSAccessKeyId']   	= $awsaccesskey;
		$param['Action']           	= 'ListInboundShipmentItems'; 
		$param['MWSAuthToken']	   	= $mwsauthtoken;
		$param['SellerId']        	= $sellerid; 
		$param['SignatureMethod']  	= 'HmacSHA256';  
		$param['SignatureVersion'] 	= '2'; 
		$param['Timestamp']        	= date("c", time());
		$param['Version']          	= '2010-10-01'; 
		$param['ShipmentId'] 		= $shpid;

		// Generate request url
		$requestURL = $this->GenerateRequestURL($secretkey, $param);

		// Make curl request
		return $this->CurlRequest($requestURL);
	}

	/**
	 * [ListInboundShipmentItemsByNextToken description]
	 * @param [type] $sellerid     [description]
	 * @param [type] $mwsauthtoken [description]
	 * @param [type] $awsaccesskey [description]
	 * @param [type] $secretkey    [description]
	 * @param [type] $nexttoken    [description]
	 */
	public function ListInboundShipmentItemsByNextToken($sellerid, $mwsauthtoken, $awsaccesskey, $secretkey, $nexttoken){
		// Create parameters
		$param = array();
		$param['AWSAccessKeyId']   	= $awsaccesskey;
		$param['Action']           	= 'ListInboundShipmentItemsByNextToken'; 
		$param['MWSAuthToken']	   	= $mwsauthtoken;
		$param['SellerId']        	= $sellerid; 
		$param['SignatureMethod']  	= 'HmacSHA256';  
		$param['SignatureVersion'] 	= '2'; 
		$param['Timestamp']        	= date("c", time());
		$param['Version']          	= '2010-10-01'; 
		$param['NextToken'] 		= $nexttoken;

		// Generate request url
		$requestURL = $this->GenerateRequestURL($secretkey, $param);

		// Make curl request
		return $this->CurlRequest($requestURL);
	}

	public function GetPackageLabels($sellerid, $mwsauthtoken, $awsaccesskey, $secretkey, $shipid, $pagetype, $numpckgs){
		// Create parameters
		$param = array();
		$param['AWSAccessKeyId']   	= $awsaccesskey;
		$param['Action']           	= 'GetPackageLabels'; 
		$param['MWSAuthToken']	   	= $mwsauthtoken;
		$param['SellerId']        	= $sellerid; 
		$param['SignatureMethod']  	= 'HmacSHA256';  
		$param['SignatureVersion'] 	= '2'; 
		$param['Timestamp']        	= date("c", time());
		$param['Version']          	= '2010-10-01'; 
		$param['ShipmentId'] 		= $shipid;
		$param['PageType'] 			= $pagetype;
		$param['NumberOfPackages'] 	= $numpckgs;

		// Generate request url
		$requestURL = $this->GenerateRequestURL($secretkey, $param);

		// Make curl request
		return $this->CurlRequest($requestURL);
	}
}

?>