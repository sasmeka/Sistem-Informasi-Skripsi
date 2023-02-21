<?php

namespace App\Libraries;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QRcodelib
{
    function cetakqr($isi)
    {
        $writer = new PngWriter();
        $qrCode = QrCode::create($isi)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $logo = Logo::create(FCPATH . 'image/Logo_UTM.png')
            ->setResizeToWidth(50);
        $result = $writer->write($qrCode, $logo);
        $dataUri = $result->getDataUri();
        $qr = '<img src="' . $dataUri . '" style="width: 60px;">';
        return $qr;
    }
}
