<?php


namespace M00t\QrCodeRenderer\QrCode\Renderer;


class GoogleChartsRenderer
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function render($text, $width, $height)
    {
        $getParams = [
            'cht' => 'qr',
            'chs' => $width . 'x' . $height,
            'choe' => 'UTF-8',
            'chl' => $text,
        ];

        try {
            return $this->httpClient->get(
                'https://chart.googleapis.com/chart?'.http_build_query($getParams)
            );
        } catch (\Exception $e) {
            throw new RenderingError('Http error: ' . $e->getMessage(), 0, $e);
        }
    }
}
