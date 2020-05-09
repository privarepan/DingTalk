<?php


namespace ThinkCar\DingTalk\Robot\Message;


use http\Exception\InvalidArgumentException;
use ThinkCar\DingTalk\Atable;

class Text extends Message
{
    use Atable;

    protected $type = 'text';

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->content = (string)$content;
        $extra = $this->getExtra();
        $this->message = array_merge($this->message, $extra);
    }

    protected function getExtra()
    {
        return [
            'at' => [
                'atMobiles' => [],
                'isAtAll' => false,
            ]
        ];
    }
}
