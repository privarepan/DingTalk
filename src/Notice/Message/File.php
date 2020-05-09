<?php


namespace ThinkCar\DingTalk\Notice\Message;


class File extends Message
{
    protected $type = 'file';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->media_id = $content;
    }
}
