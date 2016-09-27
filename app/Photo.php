<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use Sluggable, SluggableScopeHelpers;

    protected $fillable = ['path', 'filename', 'mime', 'original_filename', 'user_id'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'filename' => [
                'source' => 'original_filename',
            ]
        ];
    }
}
