<?php

namespace bconnect\MailingWork\Config;

use bconnect\MailingWork\ApiException;
use Exception;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\stream_for;

class Config
{

    private $baseUrl = 'https://login.mailingwork.de/webservice/webservice/json/';
    private $authentication;
    private $useHttpErrors = true;
    private $middleware = [];

    public function __construct()
    {
        $this->setMiddleware(Middleware::mapRequest(function (RequestInterface $request) {
            if ('POST' !== $request->getMethod()) {
                // pass the request on through the middleware stack as-is
                return $request;
            }
            // add the form-params to all post requests.
            $newRequest = new Request(
                $request->getMethod(),
                $request->getUri(),
                $request->getHeaders(),
                stream_for($request->getBody() . '&' . http_build_query($this->getAuthentication())),
                $request->getProtocolVersion()
            );
            return $newRequest;
        }), 'add_auth');

        $this->setMiddleware(Middleware::mapResponse(function (ResponseInterface $response) {
            $body = $response->getBody()->getContents();
            if (empty($body)) {
                return $response;
            }
            try {
                $json = json_decode($body);
            } catch (Exception $ex) {
                return $response;
            }
            if (isset($json->error) && $json->error === 1) {
                throw new ApiException($json->message, $json->error);
            }
            if (isset($json->error) && $json->error !== 0) {
                return $response->withBody(stream_for($body));
            }
            $json = json_encode($json->result);
            return $response->withBody(stream_for($json));
        }), 'add_error_handling');
    }

    public function setAuthentication($user, $password)
    {
        $this->authentication = [
            'username' => $user,
            'password' => $password
        ];
    }

    public function middleware()
    {
        return $this->middleware;
    }

    public function setMiddleware($middleware, $name)
    {
        $this->middleware[$name] = $middleware;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrk;
    }

    public function getAuthentication()
    {
        return $this->authentication;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function useHttpErrors()
    {
        return $this->useHttpErrors;
    }

}
