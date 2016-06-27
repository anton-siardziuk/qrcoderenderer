<?php

namespace M00t\QrCodeRenderer\QrCode;

use M00t\QrCodeRenderer\QrCode\Renderer\Renderer;

class QrCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testItShouldThrowErrorIfRendererIsNotSet()
    {
        $qrCode = new QrCode('text', 100, 500);

        $this->setExpectedExceptionRegExp(RendererIsNotSetError::class);

        $qrCode->generate();
    }

    public function testItShouldBeAbleToGenerateQrCode()
    {
        $qrCode = new QrCode('text', 100, 500);

        /** @var Renderer $renderer */
        $renderer = $this->prophesize(Renderer::class);
        $renderer->render('text', 100, 500)->willReturn('some data');

        $qrCode->setRenderer($renderer->reveal());

        $this->assertEquals(
            'some data',
            $qrCode->generate()
        );
    }

    /**
     * @dataProvider getInvalidParameters
     */
    public function testItCanNotBeCreatedWithInvalidParameters($text, $width, $height, $message)
    {
        try {
            $qrCode = new QrCode($text, $width, $height);
            $this->fail($message);
        } catch (\InvalidArgumentException $e) {
        }
    }

    public function getInvalidParameters()
    {
        return [
            ['', 100, 500, 'Empty text'],
            [str_repeat('a', 1001), 100, 500, 'Big text'],
            ['text', 49, 500, 'Small width'],
            ['text', 5001, 500, 'Big width'],
            ['text', 100, 49, 'Small height'],
            ['text', 100, 5001, 'Big height'],
        ];
    }
}
