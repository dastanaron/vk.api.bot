<?php

require 'classes/ApiMethods.php';

require 'config.php';

$api = new ApiMethods($user_access_tocken);

dump($api->AccountSetOnline()->APIExecute());

if (!empty($api->getError())){
    dump($api->getError());
}


/*$api = 'https://api.vk.com/method/account.getProfileInfo?access_token='.$user_access_tocken.'&v=5.64';

dump(json_decode(file_get_contents($api), true));*/

function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

