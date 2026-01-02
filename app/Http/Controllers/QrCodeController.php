<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use chillerlan\QRCode\QRCode as ChillerlanQRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;

class QrCodeController extends Controller
{
    public function show(string $code)
    {
        $link = Link::query()
            ->where('slug', $code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $shortUrl = url($link->slug);

        $qr = QrCode::format('svg')
            ->size(240)
            ->margin(1)
            ->generate($shortUrl);

        return view('qrcode.show', [
            'link' => $link,
            'shortUrl' => $shortUrl,
            'qr' => $qr,
        ]);
    }

    public function download(string $code): Response
    {
        $link = Link::query()
            ->where('slug', $code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $shortUrl = url($link->slug);

        $baseFilename = 'qr-' . $link->slug;

        // Prefer PNG download, but fall back to SVG if PNG rendering isn't available.
        if (! extension_loaded('gd') || ! function_exists('imagepng')) {
            $svg = QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->generate($shortUrl);

            return response($svg, 200)
                ->header('Content-Type', 'image/svg+xml; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="'.$baseFilename.'.svg"');
        }

        try {
            $options = new QROptions([
                'outputType' => QROutputInterface::GDIMAGE_PNG,
                'outputBase64' => false,
                // roughly ~300px depending on QR matrix size; keep consistent and readable
                'scale' => 10,
            ]);

            $png = (new ChillerlanQRCode($options))->render($shortUrl);

            if (! is_string($png) || $png === '') {
                throw new \RuntimeException('QR PNG renderer returned empty output.');
            }

            $filename = $baseFilename . '.png';

            return response($png, 200)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        } catch (\Throwable $e) {
            Log::warning('QR PNG render failed; falling back to SVG.', [
                'slug' => $link->slug,
                'user_id' => Auth::id(),
                'exception' => $e->getMessage(),
            ]);

            $svg = QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->generate($shortUrl);

            return response($svg, 200)
                ->header('Content-Type', 'image/svg+xml; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="'.$baseFilename.'.svg"');
        }
    }
}
