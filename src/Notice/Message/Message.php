<?php


namespace ThinkCar\DingTalk\Notice\Message;


use ThinkCar\DingTalk\Contracts\Atable;

abstract class Message
{
    /**
     * @var $message array
     */
    protected $message;

    protected $type;

    protected $package =[];

    public function __construct($data)
    {
        $this->message = [
            'msgtype' => $this->type,
            $this->type => [],
        ];
        $extra = $this->getExtra();
        $package = [
            'agent_id' => config('ding.work-notice.agent_id'),
//            'dept_id_list' => '',
            'userid_list' => '',
            'to_all_user' => false,
            'msg' => [],
        ];
        $this->package = $package;
        $this->message = array_merge($this->message, $extra);
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
        $this->setMsg();
        return json_encode($this->package);
    }

    public function __set($name, $value)
    {
        if (isset($this->message[$this->type])) {
            $this->message[$this->type][$name] = $value;
            return ;
        }
        throw new \Exception("属性不存在");
    }

    protected function setMsg()
    {
        $this->package['msg'] = $this->message;
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

    public function addReceivers($receivers)
    {
        $need = '';
        if (is_array($receivers)) {
            $need = implode(',',$receivers);
        }

        if (is_string($receivers)) {
            $need = trim($receivers, ',');
        }

        if (func_num_args() > 1) {
            $args = func_get_args();
            $need = implode(',',$args);
        }
        $this->package['userid_list'] .= $need;
    }

    public function replace($content)
    {
        $this->message[$this->getType()] = $content;
        return $this;
    }
}
