<?php

namespace Depotwarehouse\SoDoge\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Shibe extends Model
{

    public $table = "shibes";

    protected $guarded = [ "id" ];
    protected $fillable = [ "views", "hash", "title", "user_id" ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function findByHash($hash)
    {
        return $this->newQuery()->where('hash', $hash)->firstOrFail();
    }

    public function view($hash)
    {
        $shibe = $this->findByHash($hash);

        if (!file_exists($shibe->finished_path)) {
            throw new ModelNotFoundException("Could not find the associated image file for shibe ID: {$shibe->id}");
        }

        $shibe->views++;
        $shibe->save();

        return $shibe;
    }

    /**
     * Get the top `x` number of Shibes by view, with  `x` defaulting to 10.
     *
     * @param $take_amount
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findTop($take_amount = 10)
    {
        return $this->orderBy('views', 'DESC')->take($take_amount)->get();
    }

    public function getFinishedPathAttribute()
    {
        return config('app.finished_upload_dir') . $this->hash;
    }

    public function getFinishedUrlAttribute()
    {
        return "/img/finished/{$this->hash}";
    }
}
