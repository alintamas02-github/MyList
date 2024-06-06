<?php
    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
   

    $sid    = "AC4da30778ec580f25ff5f2ea984b6f446";
    $token  = "80f91b7b6fd99f86fdf4f8edcdbae422";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create("+40720014440", // to
        array(
          "from" => "+13368919208",
          "body" => "Un nou utilizator s-a conectat la MyList"
        )
      );