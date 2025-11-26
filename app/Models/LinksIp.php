<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinksIp extends Model
{
	
	protected $table = 'links_ip';
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'ID_users',
        'links_id',
		'ip'
    ];

}
