<?php

namespace M00t\QrCodeRenderer\QrCode;

use Assert\Assertion;
use M00t\QrCodeRenderer\QrCode\Renderer\Renderer;

class QrCode
{
    const MIN_SIZE = 50;
    const MAX_SIZE = 5000;
    const MIN_TEXT_LENGTH = 1;
    const MAX_TEXT_LENGTH = 1000;

    private $text;
    private $width;
    private $height;

    /** @var Renderer */
    private $renderer;

    public function __construct($text, $width, $height)
    {
        Assertion::string($text);
        Assertion::integer($width);
        Assertion::integer($height);

        Assertion::minLength($text, self::MIN_TEXT_LENGTH);
        Assertion::maxLength($text, self::MAX_TEXT_LENGTH);
        Assertion::min($width, self::MIN_SIZE);
        Assertion::max($width, self::MAX_SIZE);
        Assertion::min($height, self::MIN_SIZE);
        Assertion::max($height, self::MAX_SIZE);

        $this->text = $text;
        $this->width = $width;
        $this->height = $height;
    }

    public function setRenderer(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function generate()
    {
        if ($this->renderer === null) {
            throw new RendererIsNotSetError();
        }

        return $this->renderer->render($this->text, $this->width, $this->height);
    }
}
