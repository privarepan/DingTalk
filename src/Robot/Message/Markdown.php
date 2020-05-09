<?php


namespace ThinkCar\DingTalk\Robot\Message;


use ThinkCar\DingTalk\Atable;

class Markdown extends Message
{
    use Atable;

    protected $type = 'markdown';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $extra = $this->getExtra();
        $this->message = array_merge($this->message, $extra);
        $this->title = $content['title'] ?? '';
        $this->text = $content['text'] ?? '';
    }

    public function getExtra()
    {
        return [
            'at' => [
                'atMobiles' => [],
                'isAtAll' => false,
            ]
        ];
    }


}
