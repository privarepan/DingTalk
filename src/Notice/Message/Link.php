<?php


namespace ThinkCar\DingTalk\Notice\Message;


class Link extends Message
{
    protected $type = 'link';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->messageUrl = $content['messageUrl'] ?? '';
        $this->picUrl = $content['picUrl'] ?? '';
        $this->title = $content['title'] ?? '';
        $this->text = $content['text'] ?? '';
    }
}
