<?php

namespace App\Repositories;

use App\Models\Rpixels;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class RpixelsRepository
{
    private $model;

    public function __construct( Rpixels $model ) {

        $this->model = $model;
    }

    public function getById( int $ID_users, int $id ): Collection {
		return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
							->get();
    }
	
	public function getAll(int $ID_users, String $select = '*'): Collection {	
        return $this->model
							->select(($select == '*') ? $select : explode(",", $select))
							->where( 'ID_users', $ID_users )
							->orderBy('name', 'asc')
                           	->get();
    }

    public function getAllPaginated(String $filter): LengthAwarePaginator {	
		$ID_users = Auth::id();
        return $this->model
							->where( 'ID_users', $ID_users )
							->where(function($query) use ($filter) {
								if ( !is_null($filter) && $filter != '' ) {
									$query->orWhere('name', 'like', '%'.$filter.'%');
								}
							})
							->orderBy('name', 'asc')
                           	->paginate( 20 );
    }
	
	public function add( Array $attributtes ): Rpixels {
        return $this->model->create( $attributtes );
    }

    public function update( Int $id, Array $attributtes ): Bool {
		$ID_users = Auth::id();
        return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
                           	->update( $attributtes );
    }

    public function delete( Int $id ): Bool {
		$ID_users = Auth::id();
        return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
							->delete();
    }
	
}
