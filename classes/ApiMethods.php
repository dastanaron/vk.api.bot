<?php
use GuzzleHttp\Client;

class APIHelper {

    protected $url = 'https://api.vk.com/method/';

    public $query;

    protected $token;

    public function __construct($APIKey)
    {
        $this->token = $APIKey;
        $this->query = $this->url;
    }

    public static function init($APIKey)
    {
        return new self($APIKey);
    }

    public function getProfileInfo()
    {
        $this->query .= 'account.getProfileInfo';
        return $this;
    }

    public function AccountSetOnline()
    {
        $this->query .= 'account.setOnline?voip=0';
        return $this;
    }

    public function SendMessageUser($userId, $message, $repeatFlag=false)
    {
        $random_id = crc32($userId .$message);
        $query = 'messages.send?user_id='.$userId.'&peer_id='.$userId.'&message='.urlencode($message);

        if($repeatFlag) {
            $query .= '&random_id='.$random_id;
        }

        $this->query .= $query;
        return $this;
    }

    public function getMessage($time_offset = 60)
    {
        $this->query .= 'messages.get?time_offset='.$time_offset;
        return $this;
    }

    public function getUsers($users_id)
    {
        $this->query .= 'users.get?user_ids='.$users_id;
        return $this;
    }

    public function setVersion($version='5.74')
    {
        return 'v='.$version;
    }

    public function setAccessToken($token=null)
    {
        if(!empty($token)) {
            $this->token = $token;
        }
        return $this;
    }

    public function execute($returnObject = true, $params=['version' => '5.74'])
    {
        $this->query .= '&'.$this->setVersion($params['version']).'&access_token='.$this->token;
        return $this->request($returnObject);
    }

    public function getQuery()
    {
        return $this->query;
    }

    protected function request($returnObject = true)
    {
        $client = new Client();
        $res = $client->request('GET', $this->query)->getBody()->getContents();

        return $returnObject ? json_decode($res) : $res;
    }

}
