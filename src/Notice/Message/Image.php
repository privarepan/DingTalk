<?php


namespace ThinkCar\DingTalk\Notice\Message;


class Image extends Message
{
    protected $type = 'image';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->media_id = $content ?? '';
    }
}
