<?php

namespace Depotwarehouse\SoDoge\Tests\Model;

use Depotwarehouse\SoDoge\Model\SavesAssets;
use Depotwarehouse\SoDoge\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Config;

class SavesAssetsTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        \File::copy(base_path() . "/tests/files/backup/rick-astley.jpg", base_path() . "/tests/files/rick-astley.jpg");
    }

    public function tearDown()
    {
        \File::delete(config('app.base_upload_dir') . "60ba544b59e6fe9b25f718363c8b62d7101128034cd254290801be6c169b1d03.jpg");
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_can_save_a_file_to_disk()
    {
        $filePath = base_path() . "/tests/files/rick-astley.jpg";
        $file = new UploadedFile($filePath, "rick-astley.jpg", null, null, null, true);

        $savesAssets = new SavesAssets();
        $fileName = $savesAssets->save($file);

        $this->assertEquals("60ba544b59e6fe9b25f718363c8b62d7101128034cd254290801be6c169b1d03.jpg", $fileName);
        $this->assertFileExists(Config::get('app.base_upload_dir') . "60ba544b59e6fe9b25f718363c8b62d7101128034cd254290801be6c169b1d03.jpg");
    }
}
