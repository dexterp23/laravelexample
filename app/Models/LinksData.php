<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinksData extends Model
{
	
	protected $table = 'links_data';
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'ID_users',
        'links_id',
		'ip',
		'city',
		'state',
		'country',
		'country_code',
		'continent',
		'continent_code',
		'tier',
		'browser_name',
		'browser_version',
		'os_platform',
		'timestamp_created',
		'click_type',
		'lat',
		'lng',
		'timezone',
		'currencyCode',
    ];

}
