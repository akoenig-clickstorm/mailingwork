<?php

namespace bconnect\MailingWork;

abstract class BaseApiClient
{

    protected $client;

    public static function getClient(Client $client)
    {
        return new static($client);
    }

    private function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function getErrorCodes()
    {
        return [-1 => 'Unkown Error'];
    }

    public static function getErrorCode($class, $call, $number)
    {
        if (isset($class::getErrorCodes()[$call][$number])) {
            return [$class::getErrorCodes()[$call][$number], $number];
        }
        return ['Unknown error', -1];
    }

}
