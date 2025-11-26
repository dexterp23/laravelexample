<?php

namespace App\Repositories;

use App\Models\LinksIp;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class LinksIpRepository
{
    private $model;

    public function __construct( LinksIp $model ) {

        $this->model = $model;
    }

    public function getById( int $ID_users, int $links_id, int $id ): Collection {
		return $this->model
							->where( 'id', $id )
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->get();
    }
	
	public function getByIP( int $ID_users, int $links_id, String $ip ): Collection {
		return $this->model
							->where( 'ip', $ip )
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->limit(1)
							->get();
    }
	
	public function add( Array $attributtes ): LinksIp {
        return $this->model->create( $attributtes );
    }
	
}
