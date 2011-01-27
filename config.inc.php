<?php

  /*CONFIG*/
  //No trailing slash!
  $base_url = "http://mydomain.com/textgps";

  //Twilio Config (You need a twilio account) 
  $AccountSid = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
  $AuthToken = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

  //For all intents and purposes, CallerID == fromNumber
  $CallerID = 'xxx-xxx-xxxx'; //Outgoing Caller ID. Must be authenticated with Twilio.
  $fromNumber = "xxx-xxx-xxxx";

  //Bing Maps Config
  //See http://msdn.microsoft.com/en-us/library/ff428642.aspx
  $API_KEY = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; //Bing API Key

?>
