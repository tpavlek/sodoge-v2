<?php

namespace Depotwarehouse\SoDoge\Model;

use Depotwarehouse\SoDoge\Model\ValueObjects\Phrase;
use Illuminate\Support\Collection;
use Intervention\Image\ImageManager;

class GeneratesImages
{

    protected $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Given a base image and a Collection of phrases, we will generate the new image and save it to the finished
     * folder.
     *
     * @param $base_image_hash
     * @param \Illuminate\Support\Collection $phrases
     * @return string
     */
    public function generate($base_image_hash, Collection $phrases)
    {
        $img = $this->imageManager->make(config('app.base_upload_dir') . $base_image_hash);

        $phrases->each(function (Phrase $phrase) use ($img) {
            $img->text(
                $phrase->toString(),
                $phrase->getX(),
                $phrase->getY(),
                function ($font) use ($phrase) {
                    $fontFile = storage_path() . '/fonts/comicsans.ttf';

                    $font->color = $phrase->getColor();
                    $font->size = $phrase->getFontSize();
                    $font->file = $fontFile;
                    $font->valign = "top";
                }
            );
        });

        $ext = explode(".", $base_image_hash)[1];
        $tmpPath = config('app.tmp_upload_dir') . explode(".", $base_image_hash)[0] . "_" . uniqid() . "." . $ext;
        $img->save($tmpPath);
        $newHash = hash_file("sha256", $tmpPath);
        $newFileName = "{$newHash}.{$ext}";
        \File::move($tmpPath, config('app.finished_upload_dir') . $newFileName);

        return $newFileName;
    }

}
