<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

use Cviebrock\EloquentSluggable\Sluggable;  // Slugs


class User extends Authenticatable
{
    use Notifiable, Sluggable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first', 'last', 'password', 'email', 'works_as', 'level', 'phone', 'birth_date', 'details', 'tags', 'active', 'pic', 'resume'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
                'source' => [
                    'first', 'last'
                ],
                'on_update' => 'true',
            ]
        ];
    }

    // Get user first name attribute value
    public function getFirstAttribute($value)
    {
        return ucfirst($value);
    }
    // Get user last name attribute value
    public function getLastAttribute($value)
    {
        return ucfirst($value);
    }

    // Get birth date attribute value
    public function getBirthDateAttribute($value)
    {
        return new Carbon($value);
    }


    /**
     * Convert the tags string to array
     *
     * @return array
     */
    public function getTagsAttribute($value)
    {
        if (!$value) {
            return [];
        }

        return explode(',', $value);
    }


    // The relationship with jobs
    public function jobs()
    {
        return $this->hasMany('App\Job', 'user_id', 'id');
    }

    // Relationship with roles
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function applies()
    {
        return $this->belongsToMany('App\Job', 'job_user', 'user_id', 'job_id');
    }

    /** 
     * Check if the user has certien role
     * 
     * @var string/array
     * 
     * @return boolean
     */
    public function hasRole($roles)
    {

        // Convert the role to array if it's not
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        // Return true if the user has the role otherwise return false
        return $this->roles()->whereIn('name', $roles)->first() ? true : false;
    }
}
