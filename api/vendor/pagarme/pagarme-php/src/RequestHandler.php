<?php

namespace PagarMe;

class RequestHandler
{
    /**
     * @param array $options
     * @param string $apiKey
     *
     * @return array
     */
    public static function bindApiKeyToBasicAuth(array $options, $apiKey)
    {
        $options['headers']['Authorization'] = 'Basic ' . base64_encode($apiKey.':');

        return $options;
    }
}
