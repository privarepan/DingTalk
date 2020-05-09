<?php


namespace ThinkCar\DingTalk\Robot\Message;


class ActionCard extends Message
{
    protected $type = 'actionCard';

    public function __construct($content=null)
    {
        parent::__construct($content);
        $this->title = $content['title'] ?? '';
        $this->text = $content['text'] ?? '';
        $this->singleTitle = $content['singleTitle'] ?? '';
        $this->btnOrientation = $content['btnOrientation'] ?? '0';
        $this->singleURL = $content['singleURL'] ?? '';
        $this->btns = $content['btns']??[];
    }

    /**添加按钮 支持批量
     * ['title' => 'xxx', 'singleURL' => 'xxx'] or [['title' => 'xxx','actionURL' => 'xxx']]
     * @param $buttons array
     * @return $this
     */
    public function addButton($buttons)
    {
        $current = current($buttons);
        if (is_array($current)){
            foreach ($buttons as $button) {
                array_push($this->message[$this->type]['btns'], $button);
            }
        }else{
            array_push($this->message['btns'], $buttons);
        }
        return $this;
    }
}
