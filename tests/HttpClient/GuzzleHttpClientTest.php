<?php


namespace M00t\QrCodeRenderer\HttpClient;


use M00t\QrCodeRenderer\QrCode\Renderer\HttpError;

class GuzzleHttpClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var GuzzleHttpClient */
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttpClient();

        $this->markTestSkipped('Do not run these tests automatically, since they rely on google.com');
    }

    public function testItCanGetUrl()
    {
        $this->assertContains('google', $this->client->get('https://google.com'));
    }

    public function testItShouldThrowHttpExceptionOnError()
    {
        $this->setExpectedExceptionRegExp(HttpError::class, '#Bad response: 404#');

        $this->client->get('https://google.com/unknown_url');
    }
}
