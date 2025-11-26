<?php

namespace App\Repositories;

use App\Models\Domains;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class DomainsRepository
{
    private $model;

    public function __construct( Domains $model ) {

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
	
	public function getAllNoUsers(): Collection {	
        return $this->model
							->select('*')
                           	->get();
    }
	
	public function getBySubdomain( String $subdomain, int $id ): Collection {
		return $this->model
							->where( 'subdomain', $subdomain )
							->where( 'id', '!=', $id )
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
	
	public function add( Array $attributtes ): Domains {
        return $this->model->create( $attributtes );
    }

    public function update( Int $id, Array $attributtes ): Bool {
		$ID_users = Auth::id();
        return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
                           	->update( $attributtes );
    }
	
	public function updateNoUser( Int $id, Array $attributtes ): Bool {
        return $this->model
							->where( 'id', $id )
                           	->update( $attributtes );
    }

    public function delete( Int $id ): Bool {
		$ID_users = Auth::id();
        return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
							->delete();
    }
	
	public function chkSlug( int $ID_users, int $id, String $slug ): Collection {
		return $this->model
							->where( 'id', '!=', $id )
							->where( 'slug', '=', $slug )
							->where( 'ID_users', $ID_users )
							->get();
    }
	
	public function getByCname( String $cname ): Collection {
		return $this->model
							->where( 'cname', '=', $cname )
							->get();
    }
	
}
