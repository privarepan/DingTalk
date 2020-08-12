<?php


namespace ThinkCar\DingTalk\Robot\Message;


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
