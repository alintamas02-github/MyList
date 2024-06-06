<?php
    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
   

    $sid    = "";
    $token  = "";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create("", // to
        array(
          "from" => "",
          "body" => "Un nou utilizator s-a conectat la MyList"
        )
      );