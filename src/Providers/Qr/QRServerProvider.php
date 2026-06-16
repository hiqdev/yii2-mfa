<?php
/**
 * PHP 8.5 compatible QR code provider using file_get_contents instead of curl.
 * Avoids curl_close() which is deprecated since PHP 8.5.
 */

namespace hiqdev\yii2\mfa\Providers\Qr;

use RobThree\Auth\Providers\Qr\IQRCodeProvider;
use RobThree\Auth\Providers\Qr\QRException;

class QRServerProvider implements IQRCodeProvider
{
    public function __construct(
        private readonly string $errorcorrectionlevel = 'L',
        private readonly int    $margin = 4,
        private readonly int    $qzone = 1,
        private readonly string $bgcolor = 'ffffff',
        private readonly string $color = '000000',
        private readonly string $format = 'png',
    ) {}

    /**
     * @throws QRException
     */
    public function getMimeType(): string
    {
        return match (strtolower($this->format)) {
            'png'         => 'image/png',
            'gif'         => 'image/gif',
            'jpg', 'jpeg' => 'image/jpeg',
            'svg'         => 'image/svg+xml',
            'eps'         => 'application/postscript',
            default       => throw new QRException(sprintf('Unknown MIME-type: %s', $this->format)),
        };
    }

    public function getQRCodeImage($qrtext, $size): string|false
    {
        $url = $this->getUrl($qrtext, $size);

        $context = stream_context_create([
            'http' => [
                'timeout'    => 10,
                'user_agent' => 'TwoFactorAuth',
            ],
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]);

        return file_get_contents($url, false, $context);
    }

    private function getUrl(string $qrtext, int $size): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/'
            . '?size=' . $size . 'x' . $size
            . '&ecc=' . strtoupper($this->errorcorrectionlevel)
            . '&margin=' . $this->margin
            . '&qzone=' . $this->qzone
            . '&bgcolor=' . $this->decodeColor($this->bgcolor)
            . '&color=' . $this->decodeColor($this->color)
            . '&format=' . strtolower($this->format)
            . '&data=' . rawurlencode($qrtext);
    }

    private function decodeColor(string $value): string
    {
        return vsprintf('%d-%d-%d', sscanf($value, '%02x%02x%02x'));
    }
}
