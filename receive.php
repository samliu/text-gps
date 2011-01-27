<?php
  require_once('config.inc.php');

  //Text message format:
  //NUMBER STREET STREETABBR TOWN STATE
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    $reply_number = $_REQUEST['From'];
    $msg = $_REQUEST['Body'];
    $words = split(' ', $msg);
    //Parse body for params to our response script
    $to = "me@debugEmailAddress.com";
    $subject = "Debuggin";
    $body = "DEBUG EMAIL: $msg";

    //PARSING BEGIN
    $i=0;
    foreach($words as $word){
      $word = trim($word);
      if(strtolower($word) == "none"){ continue; }
      if($i<3){
        //First address line
        if($i==2){
          $o2.=$word.",";
        }else{
          $o2.=$word."%20";
        }
      }elseif($i<5){
        //Second address line
        if($i==3)
          $o2.=$word.",";
        if($i==4)
          $o2.=$word;
      }elseif($i<8){
        //First destination line
        if($i==7){
          $d2.=$word.",";
        }else{
          $d2.=$word."%20";
        }
      }elseif($i<10){
        //Second destination line
        if($i==8)
          $d2.=$word.",";
        if($i==9)
          $d2.=$word;
      }
      $i++;
    }
    $body.="<br/> $o2 to $d2";

    //curl my other script to send directions!
    $request_string = $base_url."/response.php?o1=$o2&d1=$d2&number=$reply_number";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return as string
    $response = curl_exec($ch);
    curl_close($ch);

    $body.=$request_string;

    //Uncomment to receive debug emails
    //mail($to, $subject, $body);
?>    
<Response>
    <Sms></Sms>
</Response>


