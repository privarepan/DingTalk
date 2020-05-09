<?php

namespace DingTalk\Tests;

use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ThinkCar\DingTalk\Facades\WorkNotice;
use ThinkCar\DingTalk\Notice\Auth\DingTalkAuth;
use ThinkCar\DingTalk\Notice\Message\Oa;
use ThinkCar\DingTalk\Robot\Message\ActionCard;
use ThinkCar\DingTalk\Robot\Message\FeedCard;
use ThinkCar\DingTalk\Robot\Message\Link;
use ThinkCar\DingTalk\Robot\Message\Markdown;
use ThinkCar\DingTalk\Robot\Message\Text;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return
     */
    public function testText()
    {
        $text = new Text();
        $text->content = '发送内容';
        return $this->app->make('robot')->push($text)->toArray();
    }

    public function testActionCard1()
    {
        $card = new ActionCard();
        $card->title = '这是多个按钮的独立跳转';
        $card->text = '![](https://www.mythinkcar.cn/Home/img/binner1-4.jpg)
 ### 乔布斯 20 年前想打造的苹果咖啡厅
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划';
        $card->addButton([
            [
                'title' => '第一个标题',
                'actionURL' => 'https://mythinkcar.cn',
            ],
            [
                'title' => '第二个标题',
                'actionURL' => 'https://mythinkcar.cn',
            ]
        ]);
        $response = app('robot')->push($card);
        dump($response->toArray());
        return $response;
    }

    public function testActionCard2()
    {
        $card = new ActionCard();
        $card->title = '这是card整体跳转';
        $card->text = '![](https://www.mythinkcar.cn/Home/img/binner1-4.jpg)
 ### 乔布斯 20 年前想打造的苹果咖啡厅
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划';
        $card->singleTitle = '阅读全文';
        $card->singleURL = 'https://www.dingtalk.com/';
        $response = app('robot')->push($card);
        dump($response->toArray());
        return $response;
    }

    public function testLink()
    {
        $link = new Link();
        $link->title = '连接的标题';
        $link->text = '即将到来的新版本';
        $link->messageUrl = 'https://mythinkcar.cn';
        $response = app('robot')->push($link);
        dump($response->toArray());
        return $response;
    }

    public function testMarkdown()
    {
        $markdown = new Markdown();
        $markdown->title = '这是markdown标题';
        $markdown->text = '![](https://www.mythinkcar.cn/Home/img/binner1-4.jpg)
 ### 我就是我不一样的烟火
 ';
        $markdown->At('18674041316','text');
        $response = app('robot')->push($markdown);
        dump($response->toArray());
        return $response;
    }

    public function testFeedCard()
    {
        $card = new FeedCard();
        $card->addLink([
            'title' => '我就是我不一样的烟火1',
            'messageURL' => 'https://mythinkcar.cn',
            'picURL' => 'https://www.mythinkcar.cn/Home/img/binner1-4.jpg'
        ])->addLink([
            'title' => '我就是我不一样的烟火2',
            'messageURL' => 'https://mythinkcar.cn',
            'picURL' => 'https://www.mythinkcar.cn/Home/img/binner1-4.jpg'
        ]);
        $response = app('robot')->push($card);
        dump($response->toArray());
        return $response;
    }

    public function testToken()
    {
        $auth = app(DingTalkAuth::class);
        $token = $auth->token();
        dump($token);
    }

    public function testGetUserId()
    {
        $auth = app(DingTalkAuth::class);

        $userId = $auth->userId('18674041316');
        dump($userId);
    }

    public function testGetUser()
    {
        $auth = app(DingTalkAuth::class);
        dd($auth->user('15888406754563259'));
    }

    public function testWorkNotice()
    {
        $oa = new Oa();
        $oa->message_url = 'https://www.dingtalk.com/';
        $oa->pc_message_url = 'https://www.dingtalk.com/';
        $oa->file_count = 0;
        $oa->head = [
            'bgcolor' => 'FFBBBBBB',
            'text' => '腾讯科技',
        ];
        $oa->body = [
            'title' => '这是正文，请向下阅读',
            'form' => [
                [
                    'key' => '姓名',
                    'value' => 'supper Pan'
                ]
            ],
            'rich' => [
                'num' => 1,
                'unit' => '篇'
            ],
            'content' => 'wwwwwwww',
            'file_count' => 0,
            'author' => 'pan zhang yi',
        ];
        $oa->addReceivers(['15888406754563259']);
//        dd((string)($oa));
        dd(WorkNotice::push($oa));
    }
}
