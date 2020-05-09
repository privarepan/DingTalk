<?php


namespace ThinkCar\DingTalk\Robot\Client;


use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ThinkCar\DingTalk\Robot\Message\Message;
use ThinkCar\DingTalk\Support\Response;

class DingTalkRobotClient
{
    /**
     * @var $sign array
     */
    protected  $sign;

    /**
     * @var Client $client
     */
    protected $client;
    /**
     * @var $request Request
     */
    protected $request;
    /**
     * @var $logger Logger
     */
    protected $logger;
    protected $base_uri = 'https://oapi.dingtalk.com/robot';

    public function __construct()
    {
        $default = config('ding.robot.default');
        $config = config('ding.robot.'.$default);
        $this->buildSign($config);
        $this->registerLogger(config('ding.log.robot'));
        $this->client = app('ding.http');
    }

    protected function registerLogger($config)
    {
        $this->logger = new Logger($config['channel_name']);
        $handler = new StreamHandler($config['path'],$config['level']);
        $handler->setFormatter(new JsonFormatter());
        $this->logger->pushHandler($handler);
    }

    /** 切换机器人 通过配置文件里面name
     * @param $name
     * @return $this
     */
    public function setRobot($name)
    {
        if ($config = config('ding.robot.' . $name, null)) {
            $query = $this->buildSign($config);
            $this->sign = $query;
        }
        return $this;
    }

    /** 设置签名
     * @param $config
     * @return array
     */
    protected function buildSign($config) :array
    {
        $now = now();
        $timestamp = $now->timestamp.$now->milli;
        $secret = $config['secret'];
        $sign = hash_hmac("sha256",$timestamp."\n".$secret,$secret,true);
        $config['timestamp'] = $timestamp;
        $config['sign'] = base64_encode($sign);
        $this->sign = $config;
        return $config;
    }

    protected function setRequest(Message $message,$method,$uri)
    {
        $request =  new Request($method,$this->base_uri.$uri, [
            'Content-Type' => 'application/json'
        ],
            $message
        );
        return $request;
    }

    /**推送消息
     * @param Message $message
     * @return \Illuminate\Support\Collection|Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function push(Message $message)
    {
        $request = $this->setRequest($message,'post','/send');
        try {
            $response = $this->client->send($request, ['query' => $this->sign]);
            $data = json_decode($response->getBody()->getContents(),true);
            return collect($data) ;
        } catch (RequestException $exception) {
            if ($exception->hasResponse()) {
                $exception->getResponse()->getBody()->getContents();
                $this->logger->info("钉钉机器人消息推送错误",[$exception]);
                return new Response();
            }
        }
    }
}
