<?php


namespace ThinkCar\DingTalk\Robot\Message;


class File extends Message
{
    public function __construct($content)
    {
        $this->message = [
            'msgtype' => 'file',
            'file' => [
                'media_id' => $content,
            ]
        ];
    }
}
