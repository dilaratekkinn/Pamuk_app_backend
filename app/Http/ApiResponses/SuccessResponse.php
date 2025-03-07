<?php
namespace App\Http\ApiResponses;

use Illuminate\Http\JsonResponse;

class SuccessResponse implements ResponseInterface{


    private bool $status;
    private $data;
    private int $code;
    private $messages;

    public function __construct()
    {
        $this->status = true;
        $this->data = new \stdClass();
        $this->code = 200;
        $this->messages = new \stdClass();
    }

    public function setStatus(bool $status = true): static
    {
        $this->status = $status;

        return $this;
    }

    public function setData($data = []): static
    {
        $this->data = $data;

        return $this;
    }


    public function setCode(int $code = 200): static
    {
        $this->code = $code;

        return $this;
    }

    public function setMessages($messages): static
    {
        $this->messages = $messages;

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getData()
    {
        return $this->data;
    }


    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function send(): JsonResponse
    {
        return response()->json([
            'status' => $this->getStatus(),
            'messages' => $this->getMessages(),
            'data' => $this->getData(),
        ], $this->getCode());
    }
}
