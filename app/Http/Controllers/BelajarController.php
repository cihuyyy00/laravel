<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class BelajarController extends Controller
{
    public function itung ($a1, $a2) {
        $hasil = $a1 * $a2;

        return view('itung', [
            'a1' => $a1,
            'a2' => $a2,
            'hasil' => $hasil
        ]); 
    }

    public function kuadrat($b1) {
        $hasiL = $b1 * $b1;

        return view('kuadrat', [
            'b1' => $b1,
            'hasiL' => $hasiL
        ]);
    }
}
