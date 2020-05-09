<?php


namespace ThinkCar\DingTalk\Robot\Message;


use ThinkCar\DingTalk\Contracts\Atable;

abstract class Message
{
    /**
     * @var $message array
     */
    protected $message;

    protected $type;

    public function __construct($data)
    {
        $this->message = [
            'msgtype' => $this->type,
            $this->type => [],
        ];
    }

    protected function getExtra()
    {
        return [];
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->message);
    }

    public function __set($name, $value)
    {
        if (isset($this->message[$this->type])) {
            $this->message[$this->type][$name] = $value;
            return ;
        }
        throw new \Exception("属性不存在");
    }

    public function __get($name)
    {
        if (isset($this->message[$this->type])) {
            return $this->message[$this->type][$name] ?? null;
        }
        return null;
    }

    public function getType()
    {
        return $this->type;
    }

    public function replace($content)
    {
        $this->message[$this->getType()] = $content;
        return $this;
    }
}
