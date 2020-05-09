<?php


namespace ThinkCar\DingTalk\Robot\Message;


class FeedCard extends Message
{
    protected $type = 'feedCard';

    public function __construct($content = [])
    {
        parent::__construct($content);
        $this->links = $content;
    }

    public function addLink($links)
    {
        $current = current($links);
        if (is_array($current)){
            foreach ($links as $link) {
                array_push($this->message[$this->type]['links'], $link);
            }
        }else{
            array_push($this->message[$this->type]['links'], $links);
        }
        return $this;
    }
}
