<?php


namespace ThinkCar\DingTalk\Robot\Message;


class Voice extends Message
{
    public function __construct($content)
    {
        $this->message = [
            'msgtype' => 'voice',
            'voice' => [
                'media_id' => $content['media_id'],
                'duration' => $content['duration'],
            ]
        ];
    }
}
