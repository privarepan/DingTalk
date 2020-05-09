<?php


namespace ThinkCar\DingTalk\Notice\Message;


class Text extends Message
{
    protected $type = 'text';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->content = (string)$content;
    }

}
