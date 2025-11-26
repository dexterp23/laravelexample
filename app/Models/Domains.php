<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
	
	protected $table = 'domains';
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ID_users',
		'name',
		'slug',
		'url',
		'cname', 
		'default_url',
		'pixel_code',
		'is_forward',
		'domain',
		'subdomain',
    ];

}
