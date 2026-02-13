<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function myQr()
    {
        $user = auth()->user();

        // Générer un nouveau token pour chaque scan
        $user->qr_token = Str::uuid();
        $user->save();

        // URL complète pour le QR code
        $url = url('/add-friend/'.$user->qr_token);

        // Générer le QR code avec l'URL complète
        $qr = QrCode::size(200)->generate($url);

        return response()->json(['qr' => (string) $qr]);
    }
}
