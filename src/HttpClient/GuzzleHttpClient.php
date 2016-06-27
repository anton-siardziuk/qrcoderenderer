<?php

namespace M00t\QrCodeRenderer\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use M00t\QrCodeRenderer\QrCode\Renderer\HttpClient;
use M00t\QrCodeRenderer\QrCode\Renderer\HttpError;

class GuzzleHttpClient implements HttpClient
{
    public function get($url)
    {
        $guzzle = new Client();

        try {
            return $guzzle->get($url)->getBody()->getContents();
        } catch (BadResponseException $e) {
            throw new HttpError('Bad response: ' . $e->getResponse()->getStatusCode(), 0, $e);
        }
    }
}
