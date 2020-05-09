<?php

namespace ThinkCar\DingTalk\Notice;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
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

    /** 推送工作消息
     * @param Message $message
     * @return mixed
     */
    public function push(Message $message)
    {
        try {
            $response = $this->client->post($this->base_uri . 'asyncsend_v2', [
                'query' => [
                    'access_token' => $this->auth->token(),
                ],
                'body' => $message
            ])->getBody()->getContents();
            $data = json_decode($response, true);
            return $data;
        } catch (RequestException $exception) {
            if ($exception->hasResponse()) {
                $exception->getResponse()->getBody()->getContents();
                Log::error("钉钉工作消息推送错误",[$exception]);
            }
        }

    }

}
