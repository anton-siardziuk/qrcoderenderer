<?php

use M00t\QrCodeRenderer\QrCode\QrCode;
use M00t\QrCodeRenderer\QrCode\Renderer\GoogleChartsRenderer;

require_once __DIR__ . '/../vendor/autoload.php';

$qrCode = new QrCode($_GET['t'], (int) $_GET['w'], (int) $_GET['h']);
$qrCode->setRenderer(new GoogleChartsRenderer());
header('Content-Type: image/png');
echo $qrCode->generate();
