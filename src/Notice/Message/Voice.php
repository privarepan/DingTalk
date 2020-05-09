<?php


namespace ThinkCar\DingTalk\Notice\Message;


class Voice extends Message
{
    protected $type = 'voice';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->media_id = $content['media_id'] ?? '';
        $this->duration = $content['duration'] ?? '';
    }
}
