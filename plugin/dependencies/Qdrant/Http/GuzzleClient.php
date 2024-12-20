<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace AIKit\Dependencies\Qdrant\Http;

use AIKit\Dependencies\GuzzleHttp\Client;
use AIKit\Dependencies\GuzzleHttp\Exception\ClientException;
use AIKit\Dependencies\GuzzleHttp\Exception\GuzzleException;
use JsonException;
use AIKit\Dependencies\Psr\Http\Client\ClientExceptionInterface;
use AIKit\Dependencies\Psr\Http\Message\RequestInterface;
use AIKit\Dependencies\Qdrant\Config;
use AIKit\Dependencies\Qdrant\Exception\InvalidArgumentException;
use AIKit\Dependencies\Qdrant\Exception\ServerException;
use AIKit\Dependencies\Qdrant\Response;

class GuzzleClient implements HttpClientInterface
{
    protected Config $config;
    protected Client $client;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $this->config->getDomain(),
            'http_errors' => true,
        ]);
    }

    private function prepareHeaders(RequestInterface $request): RequestInterface
    {
        $request = $request->withHeader('content-type', 'application/json')
            ->withHeader('accept', 'application/json');

        if ($this->config->getApiKey()) {
            $request = $request->withHeader('api-key', $this->config->getApiKey());
        }

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @return Response
     * @throws InvalidArgumentException
     * @throws JsonException
     * @throws ServerException
     * @throws ClientExceptionInterface
     */
    public function execute(RequestInterface $request): Response
    {
        $request = $this->prepareHeaders($request);
        try {
            $res = $this->client->sendRequest($request);

            return new Response($res);
        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode >= 400 && $statusCode < 500) {
                throw new InvalidArgumentException($e->getMessage());
            } elseif ($statusCode >= 500) {
                throw new ServerException($e->getMessage());
            }
        }
    }
}