<?php

namespace M00t\QrCodeRenderer\QrCode\Renderer;

interface Renderer
{
    public function render($text, $width, $height);
}
