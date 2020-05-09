<?php


namespace App\ThinkCar\DingTalk\Message;


class Image extends Message
{
    public function __construct($content)
    {
        $this->message = [
            'msgtype' => 'image',
            'image' => [
                'media_id' => $content
            ]
        ];
    }
}
