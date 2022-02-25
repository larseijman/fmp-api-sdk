<?php

namespace Leijman\FmpApiSdk;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;

class Client implements Fmp
{
    /**
     * @var Guzzle|null
     */
    private $client = null;

    /**
     * Client constructor.
     *
     * @param  Guzzle  $client
     */
    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }

    /**
     * @param  RequestInterface  $request
     * @param  array  $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws InvalidData
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        try {
            parse_str(parse_url($request->getUri(), PHP_URL_QUERY), $query);

            return $this->client->send($request, [
                'query' => array_merge($this->client->getConfig('query') ?? [], $query)
            ]);
        } catch (ClientException $e) {
            throw InvalidData::invalidDataProvided($e->getMessage());
        }
    }
}
