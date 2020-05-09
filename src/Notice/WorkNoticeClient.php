<?php

namespace ThinkCar\DingTalk\Notice;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ThinkCar\DingTalk\Notice\Auth\DingTalkAuth;
use ThinkCar\DingTalk\Notice\Message\Message;
use ThinkCar\DingTalk\Support\Response;


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
    /**
     * @var $logger Logger
     */
    protected $logger;

    public function __construct(DingTalkAuth $auth)
    {
        $this->client = app('ding.http');
        $this->auth = $auth;
        $config = config('ding.log.work-notice');
        $this->registerLogger($config);
    }

    protected function registerLogger($config)
    {
        $this->logger = new Logger($config['channel_name']);
        $handler = new StreamHandler($config['path'],$config['level']);
        $handler->setFormatter(new JsonFormatter());
        $this->logger->pushHandler($handler);
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
            return new Response($response);
        } catch (RequestException $exception) {
            if ($exception->hasResponse()) {
                $exception->getResponse()->getBody()->getContents();
                $this->logger->info("钉钉工作消息推送错误",[$exception]);
                return new Response();
            }
        }

    }

}
