<?php


namespace ThinkCar\DingTalk;


trait Atable
{
    public function addContent($msg,$field = 'content')
    {
        $this->message[$this->type][$field] .= $msg;
        return $this;
    }

    protected function addAtMobiles($mobile)
    {
        return array_push($this->message['at']['atMobiles'], $mobile);
    }

    public function At($mobiles, $field = 'content', $isAtAll = false)
    {
        if (is_array($mobiles)) {
            foreach ($mobiles as $mobile) {
                $this->addContent('@' . $mobiles . ' ',$field);
                $this->addAtMobiles($mobile);
            }
            return $this;
        }

        if (is_string($mobiles) && $mobiles) {
            $this->addContent('@' . $mobiles . ' ',$field);
            $this->addAtMobiles($mobiles);
            return $this;
        }
    }

    public function AtAll()
    {
        $this->message['at']['isAtAll'] = true;
        return $this;
    }
}
