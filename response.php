<?php                                               
  require_once('config.inc.php');

  //Target Phone Number
  $number = $_REQUEST['number'];     //Target Phone Number

  // include the PHP TwilioRest library
  require "twilio.php";
  $ApiVersion = "2010-04-01";
  $client = new TwilioRestClient($AccountSid, $AuthToken);

  $bingMaps = "http://dev.virtualearth.net/REST/v1/Routes";
  $mapsURL = array();
  $mapsURL[0] = "?waypoint.1=";
  $mapsURL[1] = "&waypoint.2=";
  $mapsURL[2] = "&key=";
  /*
    $googleMaps = "http://maps.googleapis.com/maps/api/directions/json";
    $mapsURL = array();
    $mapsURL[0] = "?origin=";
    $mapsURL[1] = "&destination=";
    $mapsURL[2] = "&region=";
    $mapsURL[3] = "&sensor=";
  */

  //Request Parameters
  $params[0] = urlencode(strip_tags($_REQUEST["o1"])); //Origin Line
  $params[1] = urlencode(strip_tags($_REQUEST["d1"])); //Destination Line
  $params[2] = $API_KEY;//API KEY

  //GOOGLE
  //$params[2] = "us";
  //$params[3] = "false";

  //GOOGLE
  //$finalURL = $googleMaps;
  $finalURL = $bingMaps;

  $i = 0;
  foreach ($mapsURL as $param){
    $finalURL = $finalURL.$param.$params[$i];
    $i++;
  }
  echo $finalURL;

  //Curl the resource and recieve json as string
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $finalURL);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return as string
  $json = curl_exec($ch);
  curl_close($ch);

  echo $json;

  $instructions = json_decode($json,true);
  print "$instructions";
  print_r($instructions);
  //GOOGLE
  //$instruction = $instructions["routes"][0]["legs"][0]["steps"];
  $instruction = $instructions["resourceSets"][0]["resources"][0]["routeLegs"][0]["itineraryItems"];
  $step_number = 1;
  foreach($instruction as $step){

    //GOOGLE
    $msg = strip_tags($step["instruction"]["text"]);
    
    // Send a new outgoinging SMS by POSTing to the SMS resource
    $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
      "POST", array(
        "To" => $number,
        "From" => $fromNumber,
        "Body" => $step_number.") ".$msg
      ));
      if($response->IsError)
        echo "Error: {$response->ErrorMessage}";
      else
        echo "Sent message";
    $step_number++;
  }


  /* DEBUG
    print "<br><br><b>DEBUG BELOW</b><br>";
    print_r ($instructions["routes"][0]["legs"]);
    //var_dump(json_decode($json,true));
  */

?>
