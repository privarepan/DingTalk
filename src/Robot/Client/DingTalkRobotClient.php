<?php


namespace ThinkCar\DingTalk\Robot\Client;


use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use ThinkCar\DingTalk\Robot\Message\Message;

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
    protected $base_uri = 'https://oapi.dingtalk.com/robot';

    public function __construct()
    {
        $default = config('ding.robot.default');
        $config = config('ding.robot.'.$default);
        $query = $this->buildSign($config);
        $this->sign = $query;
        $this->client = app('ding.http');
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

    /** 推送消息
     * @param Message $message
     * @return \Illuminate\Support\Collection
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
                Log::error("钉钉机器人消息推送错误",[$exception]);
            }
        }
    }
}
