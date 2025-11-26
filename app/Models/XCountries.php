<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XCountries extends Model
{
	
	protected $table = 'x_country';
	
	public $timestamps = false;
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_code',
		'name',
		'continent',
		'offset',
		'TimeZoneId',
		'tier',
    ];

}
