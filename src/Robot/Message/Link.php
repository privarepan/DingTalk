<?php


namespace ThinkCar\DingTalk\Robot\Message;


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
