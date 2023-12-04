<?php

namespace bconnect\MailingWork;

use bconnect\MailingWork\Config\Config;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

class Client
{

    private $client;
    private $config;
    private $apis;

    private function __construct(HttpClient $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function request($url, $params = FALSE)
    {
        $this->arrayFilter($params);
        $response = $this->client->post($url, [
            'form_params' => ($params) ? $params : []
        ]);
        $json = $this->decodeBody($response);
        if ($json->error) {
            $debug = debug_backtrace()[1];
            if (!$debug['class']) {
                throw new ApiException('Unknown error occurred');
            }
            $class = $debug['class'];
            $error = $class::getErrorCode($debug['class'], $debug['function'], $json->error);
            throw new ApiException($error[0], $error[1]);
        }
        return $json;
    }

    private function arrayFilter(&$array)
    {
        if (!is_array($array)) {
            return;
        }
        foreach ($array as $key => $item) {
            is_array($item) && $array[$key] = $this->arrayFilter($item);
            if (empty ($array [$key])) {
                unset ($array[$key]);
            }
        }
        return $array;
    }

    protected function decodeBody(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
        // $body = $response->getBody()->getContents();
        // $json = new \stdClass();
        // if (empty($body)) {
        //   return $json;
        // }
        // try {

        //   $json = json_decode($body);
        // } catch (\Exception $ex) {
        // }
        // return $json;
    }

    protected function getImplementingClasses($name)
    {
        $className = '\\bconnect\\MailingWork\\Apis\\' . ucfirst($name) . 'Client';
        if (class_exists($className)) {
            return $className::getClient($this);
        }
    }

    public function api($name)
    {
        if (!isset($this->apis[$name])) {
            $class = $this->getImplementingClasses($name);
            if (!$class) {
                return FALSE;
            }
            $this->apis[$name] = $class;
        }
        return $this->apis[$name];
    }


    public static function getClient($username, $password, $url = FALSE)
    {
        $config = new Config();
        $config->setAuthentication($username, $password);
        $stack = HandlerStack::create();
        foreach ($config->middleware() as $name => $middleware) {
            $stack->push($middleware, $name);
        }
        if ($url !== FALSE) {
            $config->setBaseUrl($url);
        }
        $client = new HttpClient([
            'base_uri' => $config->getBaseUrl(),
            'http_errors' => $config->useHttpErrors(),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'handler' => $stack,
        ]);
        return new static($client, $config);
    }

}
