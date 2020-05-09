<?php

namespace ThinkCar\DingTalk\Notice;

use GuzzleHttp\Client;
use ThinkCar\DingTalk\Notice\Auth\DingTalkAuth;
use ThinkCar\DingTalk\Notice\Message\Message;


class WorkNoticeClient
{
    protected $base_uri = 'https://oapi.dingtalk.com/topapi/message/corpconversation/';
    /**
     * @var Client $client
     */
    protected $client;
    /**
     * @var DingTalkAuth $auth
     */
    protected $auth;
    public function __construct(DingTalkAuth $auth)
    {
        $this->client = app('ding.http');
        $this->auth = $auth;
    }

    public function push(Message $message)
    {
        $response = $this->client->post($this->base_uri.'asyncsend_v2',[
            'query' => [
                'access_token' => $this->auth->token(),
            ],
            'body' => $message
        ])->getBody()->getContents();
        $data = json_decode($response,true);
        return $data;
    }

}
