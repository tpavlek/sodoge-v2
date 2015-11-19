<?php

namespace Depotwarehouse\SoDoge\Console\Commands;

use Depotwarehouse\SoDoge\Model\Shibe;
use Illuminate\Console\Command;
use Symfony\Component\Finder\SplFileInfo;

class CleanUpOldImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sodoge:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes all old images with under 20 views, and all records without files';

    protected $shibes;

    /**
     * Create a new command instance.
     *
     * @param \Depotwarehouse\SoDoge\Http\Controllers\Shibes $shibes
     */
    public function __construct(Shibe $shibes)
    {
        parent::__construct();
        $this->shibes = $shibes;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->shibes->all()
            ->filter(function (Shibe $shibe) {
                // If there is no longer a finished file on disk, mark it for deletion
                if (!\File::exists($shibe->finished_path)) {
                    return true;
                }

                // If it has less than 20 views, we don't want it
                if ($shibe->views < 20) {
                    return true;
                }

                return false;
            })->each(function (Shibe $shibe) {
                // Delete the file on disk
                \File::delete($shibe->finished_path);

                $shibe->delete();
            });

        collect(\File::allFiles(public_path() . "/img/finished/"))
            ->map(function (SplFileInfo $file) {
                return $file->getRelativePathname();
            })
            ->diff($this->shibes->lists('hash'))
            ->each(function ($pathName) {
                \File::delete(public_path() . "/img/finished/{$pathName}");
            });
    }
}
