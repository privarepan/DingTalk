# DingTalk 一个钉钉机器人与工作消息提醒的工具

# 环境要求
    php:>7.1,
    laravel:>5.5
    
详细使用请阅读 [钉钉开发文档](https://ding-doc.dingtalk.com/doc#/serverapi2/gh60vz)

# 安装

`composer require thinkcar/dingtalk`
`php artisan vendor:publish --provider="ThinkCar\DingTalk\DingTalkServiceProvider"`

# 机器人

## 消息类型

 1. text
 2. link
 3. markdown 
 4. ActionCard 
 5. FeedCard


## text

```php
use ThinkCar\DingTalk\Facades\Robot;
use ThinkCar\DingTalk\Robot\Message\Text;
$text = new Text;
$text->content = '这是发送内容';
$text->At('123232321'); //表示@123232321
$text->addContent("为hello world!") // 将会与上面的内容拼接
$text->At("13911111111");//还可以继续@用户 addContent() 和At() 支持链式调用;
$response = Robot::push($text);
//判断消息是否推送成功
$response->isSuccess():bool;
//获取返回的数据结果
$response->getOrigin();
```


----------

或者你也可以这样
```php
    $text = new Text('这是发送内容');
    Robot::push($text); // or  app('ding.robot')->push($text);
```

## link

```php
    $link = new Link();
    $link->title = '连接的标题';
    $link->text = '即将到来的新版本';
    $link->messageUrl = 'https://mythinkcar.cn';
    $response = app('ding.robot')->push($link);

```

## Markdown

```php
    $markdown = new Markdown();
    $markdown->title = '这是markdown标题';
    $markdown->text = '![](https://www.mythinkcar.cn/Home/img/binner1-4.jpg)
 ### 我就是我不一样的烟火
 ';
    // @18612345678 的用户, 第二个参数，与你的消息内容字段一致，第三个参数为true和false，默认false, true:表示@所有人,false:表示不@所有人
    $markdown->At('18612345678','text'); 
    $markdown->addContent("我的小可爱",'text'); //同text 支持链式调用，第二个参数为发送内容的字段名称
    app('ding.robot')->push($markdown);

```

## ActionCard

```php
    $card = new ActionCard();
    $card->title = '这是标题';
        $card->text = '![](https://www.mythinkcar.cn/Home/img/binner1-4.jpg)
 ### 乔布斯 20 年前想打造的苹果咖啡厅
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划';
    $card->singleTitle = '阅读全文';
    $card->singleURL = 'https://www.dingtalk.com/';
    
    app('ding.robot')->push($card);
```    

## FeedCard

```php

    $card = new FeedCard();
    $card->addLink([  //添加按钮
        'title' => '我就是我不一样的烟火1',
        'messageURL' => 'https://mythinkcar.cn',
        'picURL' => 'https://www.mythinkcar.cn/Home/img/binner1-4.jpg'
    ])->addLink([
        'title' => '我就是我不一样的烟火2',
        'messageURL' => 'https://mythinkcar.cn',
        'picURL' => 'https://www.mythinkcar.cn/Home/img/binner1-4.jpg'
    ]);
    $response = app('robot')->push($card);
    
```

# 工作消息

## 消息类型
1.  text
> 不支持@
2.  image
3.  voice
4.  link
5.  oa
6.  markdown 

> 不支持@


7.  ActionCard

## Oa 消息

```php
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
    
    $oa->addReceivers(['userid']); //添加收件人
    $oa->addReceivers('userid');//效果同上,
    $oa->addReceivers('userid1','userid2','userid3');//效果同上,
    $oa->setField("body.title","这是被修改后的标题");//支持以点的形式更新(有这个字段就更新，没有就添加)oa内部字段
    app('ding.work-notice')->push($oa);
```

## voice
```php
    $voice = new Voice($content['media_id' => 'media_id','duration' => 10]);
    $response = app('ding.work-notice')->push($voice);
    // 判断是否推送成功
    $response->isSuccess():bool;
```

