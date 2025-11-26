<?php

namespace App\Repositories;

use App\Models\LinksData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class LinksDataRepository
{
    private $model;

    public function __construct( LinksData $model ) {

        $this->model = $model;
    }

    public function getById( int $ID_users, int $links_id, int $id ): Collection {
		return $this->model
							->where( 'id', $id )
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->get();
    }
	
	public function getAll(int $ID_users, int $links_id, String $select = '*'): Collection {	
        return $this->model
							->select(($select == '*') ? $select : explode(",", $select))
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->orderBy('timestamp_created', 'asc')
                           	->get();
    }
	
	public function getAllByDate(int $ID_users, int $links_id, int $date_from, int $date_to, String $select = '*'): Collection {	
        return $this->model
							->select(($select == '*') ? $select : explode(",", $select))
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->whereBetween('timestamp_created', [$date_from, $date_to])
							->orderBy('timestamp_created', 'desc')
                           	->get();
    }
	
	public function getLocationByDate(int $ID_users, int $links_id, int $date_from, int $date_to): Collection {	
        return $this->model
							->select('ip', 'lat', 'lng')
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->whereBetween('timestamp_created', [$date_from, $date_to])
							->orderBy('timestamp_created', 'desc')
							->groupBy('ip', 'lat', 'lng')
                           	->get();
    }
	
	public function getBrowsersByDate(int $ID_users, int $links_id, int $date_from, int $date_to): Collection {	
        return $this->model
							->select('browser_name')
							->where( 'browser_name', '!=', '' )
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->whereBetween('timestamp_created', [$date_from, $date_to])
							->orderBy('browser_name', 'asc')
							->groupBy('browser_name')
                           	->get();
    }
	
	public function getPlatformsByDate(int $ID_users, int $links_id, int $date_from, int $date_to): Collection {	
        return $this->model
							->select('os_platform')
							->where( 'os_platform', '!=', '' )
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->whereBetween('timestamp_created', [$date_from, $date_to])
							->orderBy('os_platform', 'asc')
							->groupBy('os_platform')
                           	->get();
    }
	
	public function getCountriesByDate(int $ID_users, int $links_id, int $date_from, int $date_to): Collection {	
        return $this->model
							->select('country_code', 'country')
							->where( 'country_code', '!=', '' )
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->whereBetween('timestamp_created', [$date_from, $date_to])
							->orderBy('country_code', 'asc')
							->groupBy('country_code', 'country')
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

    public function getAllPaginated(int $links_id, int $date_from, int $date_to): LengthAwarePaginator {	
        $ID_users = Auth::id();
        return $this->model
							->where( 'links_id', $links_id )
							->where( 'ID_users', $ID_users )
							->whereBetween('timestamp_created', [$date_from, $date_to])
							->orderBy('timestamp_created', 'desc')
                           	->paginate( 20 );
    }
	
	public function add( Array $attributtes ): LinksData {
        return $this->model->create( $attributtes );
    }
	
}
