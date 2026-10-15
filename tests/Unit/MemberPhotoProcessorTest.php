<?php

namespace Tests\Unit;

use App\Services\MemberPhotoProcessor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MemberPhotoProcessorTest extends TestCase
{
    public function test_it_center_crops_and_resizes_member_photo_to_three_hundred_by_four_hundred(): void
    {
        Storage::fake('public');

        $sourcePath = tempnam(sys_get_temp_dir(), 'member-photo-');
        $source = imagecreatetruecolor(300, 200);
        $red = imagecolorallocate($source, 240, 20, 20);
        $green = imagecolorallocate($source, 20, 220, 20);
        $blue = imagecolorallocate($source, 20, 20, 240);
        imagefilledrectangle($source, 0, 0, 99, 199, $red);
        imagefilledrectangle($source, 100, 0, 199, 199, $green);
        imagefilledrectangle($source, 200, 0, 299, 199, $blue);
        imagepng($source, $sourcePath);
        imagedestroy($source);

        try {
            $photo = new UploadedFile($sourcePath, 'source.png', 'image/png', null, true);
            $storedPath = app(MemberPhotoProcessor::class)->store($photo);
            $storedFile = Storage::disk('public')->path($storedPath);
            $dimensions = getimagesize($storedFile);
            $storedImage = imagecreatefromjpeg($storedFile);

            $this->assertSame([300, 400], [$dimensions[0], $dimensions[1]]);

            $leftPixel = imagecolorsforindex($storedImage, imagecolorat($storedImage, 30, 200));
            $centerPixel = imagecolorsforindex($storedImage, imagecolorat($storedImage, 150, 200));
            $rightPixel = imagecolorsforindex($storedImage, imagecolorat($storedImage, 270, 200));

            $this->assertGreaterThan($leftPixel['green'], $leftPixel['red']);
            $this->assertGreaterThan($centerPixel['red'], $centerPixel['green']);
            $this->assertGreaterThan($rightPixel['green'], $rightPixel['blue']);

            imagedestroy($storedImage);
        } finally {
            if (file_exists($sourcePath)) {
                unlink($sourcePath);
            }
        }
    }
}
