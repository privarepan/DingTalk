<?php


namespace ThinkCar\DingTalk\Robot\Message;


class Oa extends Message
{
    public function __construct($content = null)
    {
        $this->message = [
            'msgtype' => 'oa',
            'oa' => [
                'message_url' => $content['message_url'] ?? '',
                'head' => [
                    'bgcolor' => $content['bgcolor'] ?? '',
                    'text' => $content['text'] ?? '',
                ],
                'body' => [
                    'title' => $content['title'] ?? '',
                    'form' => $content['form'] ?? '',
                ],
                'rich' => [
                    'num' => $content['num'] ?? '',
                    'unit' => $content['unit'] ?? '',
                ],
                'content' => $content['content'] ?? '',
                'image' => $content['image'] ?? '',
                'file_count' => $content['file_count'] ?? 1,
                'author' => $content['author'] ?? '',
            ],
        ];
    }
}
