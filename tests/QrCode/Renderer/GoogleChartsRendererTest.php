<?php


namespace M00t\QrCodeRenderer\QrCode\Renderer;


use Prophecy\Argument;

class GoogleChartsRendererTest extends \PHPUnit_Framework_TestCase
{
    /** @var GoogleChartsRenderer */
    private $renderer;
    /** @var HttpClient */
    private $client;

    public function setUp()
    {
        $this->client = $this->prophesize(HttpClient::class);
        $this->renderer = new GoogleChartsRenderer($this->client->reveal());
    }

    public function testItCanRenderQrCode()
    {
        $this->client->get('https://chart.googleapis.com/chart?cht=qr&chs=100x500&choe=UTF-8&chl=hello+world')
            ->willReturn('data');

        $this->assertEquals(
            'data',
            $this->renderer->render('hello world', 100, 500)
        );
    }
    
    public function testItShouldThrowExceptionOnAnyHttpError()
    {
        $this->client->get(Argument::any())->willThrow(new HttpError('Some error'));

        $this->setExpectedExceptionRegExp(RenderingError::class, '#Http error: Some error#');

        $this->renderer->render('some text', 100, 200);
    }
}
