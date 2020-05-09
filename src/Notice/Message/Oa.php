<?php


namespace ThinkCar\DingTalk\Notice\Message;


use Illuminate\Support\Arr;

class Oa extends Message
{
    protected $type = 'oa';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->message_url = $content['message_url'] ?? '';
        $this->pc_message_url = $content['pc_message_url'] ?? '';
        $this->head = $content['head'] ?? [];
        $this->body = $content['body'] ?? [];
        $this->rich = $content['rich'] ?? [];
        $this->content = $content['content'] ?? '';
        $this->image = $content['image'] ?? '';
        $this->file_count = $content['file_count'] ?? 0;
        $this->author = $content['author'] ?? '';
        /*$this->message = [
            'msgtype' => 'oa',
            'oa' => [
                'message_url' => $content['message_url'],
                'head' => [
                    'bgcolor' => $content['bgcolor'],
                    'text' => $content['text'],
                ],
                'body' => [
                    'title' => $content['title'],
                    'form' => $content['form'],
                ],
                'rich' => [
                    'num' => $content['num'],
                    'unit' => $content['unit'],
                ],
                'content' => $content['content'],
                'image' => $content['image'],
                'file_count' => $content['file_count'],
                'author' => $content['author'],
            ],
        ];*/
    }

    public function setField($key,$value)
    {
        $key = trim($key,'.');
        Arr::set($this->message[$this->type],$key,$value);
        return $this;
    }
}
