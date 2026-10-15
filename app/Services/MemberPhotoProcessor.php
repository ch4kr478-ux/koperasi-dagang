<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class MemberPhotoProcessor
{
    public function store(UploadedFile $photo): string
    {
        $contents = file_get_contents($photo->getRealPath());
        if ($contents === false) {
            throw new RuntimeException('Pas foto anggota gagal dibaca.');
        }

        $source = imagecreatefromstring($contents);
        if ($source === false) {
            throw new RuntimeException('Pas foto anggota tidak dapat diproses.');
        }

        $destination = imagecreatetruecolor(300, 400);
        if ($destination === false) {
            imagedestroy($source);
            throw new RuntimeException('Ruang pemrosesan pas foto anggota gagal dibuat.');
        }

        try {
            $sourceWidth = imagesx($source);
            $sourceHeight = imagesy($source);

            if ($sourceWidth / $sourceHeight > 3 / 4) {
                $cropWidth = (int) floor($sourceHeight * 3 / 4);
                $cropHeight = $sourceHeight;
                $sourceX = (int) floor(($sourceWidth - $cropWidth) / 2);
                $sourceY = 0;
            } else {
                $cropWidth = $sourceWidth;
                $cropHeight = (int) floor($sourceWidth * 4 / 3);
                $sourceX = 0;
                $sourceY = (int) floor(($sourceHeight - $cropHeight) / 2);
            }

            $white = imagecolorallocate($destination, 255, 255, 255);
            imagefill($destination, 0, 0, $white);

            if (!imagecopyresampled(
                $destination,
                $source,
                0,
                0,
                $sourceX,
                $sourceY,
                300,
                400,
                $cropWidth,
                $cropHeight
            )) {
                throw new RuntimeException('Pas foto anggota gagal disesuaikan ukurannya.');
            }

            ob_start();
            $encoded = imagejpeg($destination, null, 90);
            $jpeg = ob_get_clean();

            if (!$encoded || $jpeg === false) {
                throw new RuntimeException('Pas foto anggota gagal dikonversi.');
            }
        } finally {
            imagedestroy($source);
            imagedestroy($destination);
        }

        $path = 'anggota/' . Str::uuid() . '.jpg';
        if (!Storage::disk('public')->put($path, $jpeg)) {
            throw new RuntimeException('Pas foto anggota gagal disimpan.');
        }

        return $path;
    }
}
