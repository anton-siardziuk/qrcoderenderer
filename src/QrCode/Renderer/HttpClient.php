<?php

namespace M00t\QrCodeRenderer\QrCode\Renderer;

interface HttpClient
{
    public function get($url);
}
