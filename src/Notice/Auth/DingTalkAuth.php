<?php


namespace ThinkCar\DingTalk\Notice\Auth;


use GuzzleHttp\Client;

class DingTalkAuth
{
    protected $cache_key = 'ding-talk';

    protected $base_uri = 'https://oapi.dingtalk.com';

    public function __construct()
    {
        $this->client = app('ding.http');
    }

    public function user($userId)
    {
        $response = $this->client->get($this->base_uri . '/user/get',[
            'query' => [
                'access_token' => $this->token(),
                'userid' => $userId,
            ]
        ])->getBody()->getContents();
        $data = json_decode($response,true);
        if ($data['errcode'] !== 0) {
            throw new \Exception("钉钉用户详情获取失败", $data['errcode']);
        }
        return $data;
    }

    public function token()
    {
        $token = cache()->remember($this->cache_key . ':access_token', now()->addSeconds(7000), function () {
            $response = $this->client->get($this->base_uri . '/gettoken',[
                'query' => [
                    'appkey' => config('ding.work-notice.appkey'),
                    'appsecret' => config('ding.work-notice.appsecret'),
                ]
            ])->getBody()->getContents();
            $data = json_decode($response,true);
            if ($data['errcode'] !== 0) {
                new \Exception("钉钉token获取失败", $data['errcode']);
            }
            return $data['access_token'];
        });
        return $token;
    }

    public function userId($mobile)
    {
        $response = $this->client->get($this->base_uri . '/user/get_by_mobile',[
            'query' => [
                'access_token' => $this->token(),
                'mobile' => $mobile,
            ]
        ])->getBody()->getContents();
        $data = json_decode($response,true);
        if ($data['errcode'] !== 0) {
            throw new \Exception("钉钉userId获取失败", $data['errcode']);
        }
        return $data['userid'];
    }


}
