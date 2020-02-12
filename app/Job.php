<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;  // Slugs

class Job extends Model
{

    use Sluggable;

    protected   $table = 'jobs',
        $primaryKey = 'id',
        $fillable = [
            'title', 'description', 'phone', 'email', 'work_address', 'address', 'salary', 'tags', 'details', 'pic', 'user_id'
        ];


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'on_update' => 'true',
            ]
        ];
    }


    // Relationship with user
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    // Get tags attribute
    // convert from string to array
    public function getTagsAttribute($value)
    {

        return $value ? explode(',', $value) : [];
    }


    public function users()
    {
        return $this->belongsToMany('App\User', 'job_user', 'job_id', 'user_id');
    }
}
