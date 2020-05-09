<?php

namespace ThinkCar\DingTalk\Support;

class Response
{
    protected $response;

    public function __construct(string $data = '')
    {
        $result = json_decode($data, true) ?? [];
        $this->response = collect($result);
    }

    public function isSuccess()
    {
        return $this->response->get('errcode') === 0;
    }

    public function isError()
    {
        return !$this->isSuccess();
    }

    public function getOrigin()
    {
        return $this->response;
    }
}
