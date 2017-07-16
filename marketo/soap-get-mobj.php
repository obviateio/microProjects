<?php
$debug = false;
$marketoSoapEndPoint    = "https://ENDPOINT.mktoapi.com/soap/mktows/2_9";  // CHANGE ME
$marketoUserId      = "MKTOWS_USER_SOMETHING";  // CHANGE ME
$marketoSecretKey   = "11111111222222233333333444445555555";  // CHANGE ME
$marketoNameSpace   = "http://www.marketo.com/mktows/";

// Create Signature
$dtzObj = new DateTimeZone("America/Los_Angeles");
$dtObj  = new DateTime('now', $dtzObj);
$timeStamp = $dtObj->format(DATE_W3C);
$encryptString = $timeStamp . $marketoUserId;
$signature = hash_hmac('sha1', $encryptString, $marketoSecretKey);

// Create SOAP Header
$attrs = new stdClass();
$attrs->mktowsUserId = $marketoUserId;
$attrs->requestSignature = $signature;
$attrs->requestTimestamp = $timeStamp;
$authHdr = new SoapHeader($marketoNameSpace, 'AuthenticationHeader', $attrs);
$options = array("connection_timeout" => 15, "location" => $marketoSoapEndPoint);
if ($debug) {
  $options["trace"] = 1;
}
// Create Request
$params->type = 'Program';
// $params->id = "1003";

$mObjCriteria1 = new stdClass();
$mObjCriteria1->attrName="CRM Id";
$mObjCriteria1->comparison="NE";
$mObjCriteria1->attrValue="";

/*$mObjCriteria2 = new stdClass();
$mObjCriteria2->attrName="Name";
$mObjCriteria2->comparison="NE";
$mObjCriteria2->attrValue="elizprogramtest";*/
//$params->mObjCriteriaList=array($mObjCriteria1, $mObjCriteria2);

$big = array();

do{
  if($streamPos){
    $params->streamPosition = $streamPos;
  }
  $params->mObjCriteriaList=array($mObjCriteria1);

  $soapClient = new SoapClient($marketoSoapEndPoint ."?WSDL", $options);
  try {
    $res = $soapClient->__soapCall('getMObjects', array($params), $options, $authHdr);
    print "returnCount: ".$res->result->returnCount."\n";
    //$res->result->newStreamPosition;
    print "check the count: ".count($res->result->mObjectList->mObject)."\n";
    print "First res: ".$res->result->mObjectList->mObject[0]->id."\n\n";
    foreach($res->result->mObjectList->mObject as $top){
      $line = array();
      $line['mktoid'] = $top->id;
      //print "MKTO Id: ".$top->id."\n";
      foreach($top->attribList->attrib as $val){
        if($val->name == "Name"){
          $line['mktoname'] = $val->value;
          //print "MKTO Name: ".$val->value."\n";
        }elseif ($val->name == "CRM Campaign Id"){
          $line['crmid'] = $val->value;
        }elseif($val->name == "CRM Campaign Name") {
          $line['crmname'] = $val->value;
        }
      }
      $big[] = $line;
    }
    $streamPos = $res->result->newStreamPosition;
  }
  catch(Exception $ex) {
    var_dump($ex);
  }
  if ($debug) {
    print "RAW request:\n" .$soapClient->__getLastRequest() ."\n";
    print "RAW response:\n" .$soapClient->__getLastResponse() ."\n";
  }
  print "Has more? ".$res->result->hasMore."\n";
}while($res->result->hasMore);
print "writing\n";
$fh = fopen("./out.csv",w);
fwrite($fh, "mktoid,mktoname,crmid,crmname\n");
$a = 0;
foreach($big as $l){
  //print_r($l);
  $a++;
  fwrite($fh, $l['mktoid'].",".$l['mktoname'].",".$l['crmid'].",".$l['crmname']."\n");
}
fclose($fh);
print "done -- wrote $a lines\n";

// Marketo - name, salesforce - name & id
?>
