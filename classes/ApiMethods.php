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

    public function APIExecute()
    {
        if ($this->addAccessTocken() && $this->addVersionApi()) {
            return json_decode(file_get_contents($this->api), true);
        }
        else {
            $this->error = 'Ошибка запроса не добавлены обязательные свойства запроса';
            return false;
        }
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

    public function getError()
    {
        return $this->error;
    }

}