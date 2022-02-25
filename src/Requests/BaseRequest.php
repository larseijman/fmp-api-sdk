<?php

namespace Leijman\FmpApiSdk\Requests;

use Leijman\FmpApiSdk\Contracts\Fmp;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;

abstract class BaseRequest
{
    const ENDPOINT = '';

    protected $method = 'GET';

    protected $payload = [];

    protected $api;

    protected $symbol = '';

    public function __construct(Fmp $api)
    {
        $this->api = $api;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function send(): Collection
    {
        $this->validateParams();

        $request = new Request($this->method, $this->getFullEndpoint(), [], json_encode($this->payload));

        $response = $this->api->send($request);

        return collect(json_decode($response->getBody()->getContents()));
    }

    public function get(): Collection
    {
        $this->method = 'GET';

        return $this->send();
    }

    public function post(): Collection
    {
        $this->method = 'POST';

        if (empty($this->payload)) {
            throw InvalidData::invalidDataProvided('Payload required to perform a POST request');
        }

        return $this->send();
    }

    abstract protected function getFullEndpoint(): string;

    protected function validateParams()
    {
        return true;
    }
}
