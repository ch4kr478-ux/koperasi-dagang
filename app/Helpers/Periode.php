<?php

namespace App\Helpers;

use Carbon\Carbon;

class Periode {

    public static function tanggal_id($tgl)
    {
        return (new Carbon($tgl))->locale('id')->translatedFormat('d F Y');
    }
}