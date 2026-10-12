<?php

namespace App\Helpers;

use Carbon\Carbon;

class Tanggal {

    public static function tanggal_id($tgl)
    {
        return (new Carbon($tgl))->locale('id')->translatedFormat('d F Y');
    }

    public static function convert_tanggal($tgl)
    {
        return date('Y-m-d', strtotime($tgl));
    }

    public static function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
