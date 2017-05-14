<?php

echo '===cron Start===' . PHP_EOL;

require 'classes/ApiMethods.php';

require 'config.php';

$kristinaID = 69046497;

$api = new ApiMethods($group_access_tocken);


//dump($api->getMessage()->APIExecute(false));

$message_array = $api->getMessage(120)->APIExecute(false);

$api->ClearAPI();

$array_smile= ['😂','😄','😁'];

foreach ($message_array["response"]["items"] as $item_msg){

    //dump($api->getUsers($item_msg["user_id"])->APIExecute(false));

    $name = $api->getUsers($item_msg["user_id"])->APIExecute(false)["response"][0]['first_name'];

   echo $name . ' Написал(а): ' .$item_msg["body"] . PHP_EOL;

   if (preg_match('#😂|😄|😁#', $item_msg["body"])) {
       $api->ClearAPI();

       $rand_smile = $array_smile[mt_rand(0,2)];
       dump($api->SendMessageUser($item_msg["user_id"], $rand_smile)->APIExecute());
       echo 'Бот ответил: '.$rand_smile.'' .PHP_EOL;
   }

}


if (!empty($api->getError())){
    dump($api->getError());
}

echo '===cron End===' . PHP_EOL;

function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

