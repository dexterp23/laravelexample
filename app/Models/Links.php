<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Links extends Model
{
	
	use SoftDeletes;
	
	protected $table = 'links';
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'ID_users',
        'vendor_id',
		'name',
		'url',
		'status',
		'domain_id',
		'admin_domain',
		'cloak_url',
		'text_link',
		'group_id',
		'rpixels_id',
		'date_start',
		'time_start',
		'timestamp_start',
		'date_end',
		'time_end',
		'timestamp_end',
		'page_id_pending',
		'page_id_complete',
		'click_total',
		'click_unique',
		'tracking_link',
		'rpixel_chk',
		'dates_chk',
		'pages_chk'
    ];

}
