<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rpixels extends Model
{
	
	protected $table = 'rpixels';
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ID_users',
		'name',
		'code',
    ];

}
