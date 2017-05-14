<?php

class ApiMethods{

    protected $usertocken = 0;
    protected $api = 'https://api.vk.com/method/';
    protected $error;

    function __construct($usertocken)
    {
        $this->usertocken = $usertocken;
    }

    /*
     * Сюда методы из АПИ ВК
     */
    public function getProfileInfo()
    {
        $this->api .= 'account.getProfileInfo';
        return $this;
    }

    public function AccountSetOnline()
    {
        $this->api .= 'account.setOnline?voip=0';
        return $this;
    }

    public function SendMessageUser($userid, $message)
    {
        $random_id = crc32($userid .$message);
        $this->api .= 'messages.send?user_id='.$userid.'&peer_id='.$userid.'&message='.urlencode($message).''; //&random_id='.$random_id.'
        return $this;
    }

    public function APIExecute($response = true)
    {
        if ($this->addAccessTocken() && $this->addVersionApi()) {

            if ($response) {
                return $this->CURLExec();
            }
            else {
                return json_decode($this->CURLExec(), true);
            }
            //return $this->api;
        }
        else {
            $this->error = 'Ошибка запроса не добавлены обязательные свойства запроса';
            return false;
        }
    }

    public function getMessage($time_offset = 60)
    {
        $this->api .= 'messages.get?time_offset='.$time_offset.'';
        return $this;
    }

    public function getUsers($users_id)
    {
        $this->api .= 'users.get?user_ids='.$users_id.'';
        return $this;
    }

    /*
     * Сервисные функции для обязательных полей запроса
     */
    protected function addAccessTocken()
    {
        if (preg_match('#method/(.+)#', $this->api)){

            if (preg_match('#\?#', $this->api)) {
                $this->api .= '&access_token='.$this->usertocken;
            }
            else {
                $this->api .= '?access_token='.$this->usertocken;
            }
            return true;

        }
        else {
            $this->error = 'Ошибка не вызван ни один метод апи';
            return false;
        }
    }

    protected function addVersionApi()
    {
        $this->api .= '&v=5.64';
        return true;
    }

    protected function CURLExec()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->error = $err;
        } else {
            return $response;
        }
    }

    public function getError()
    {
        return $this->error;
    }

    public function getAPI()
    {
        return $this->api;
    }

    public function ClearAPI() {
        $this->api = 'https://api.vk.com/method/';
        return $this;
    }

}