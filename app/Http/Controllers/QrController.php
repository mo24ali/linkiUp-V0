<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function myQr(){
        $user = auth()->user();

        // Générer un nouveau token et sauvegarder dans la DB
        $user->qr_token = Str::uuid();
        $user->save();

        return QrCode::size(200)->generate($user->qr_token);
    }
}
