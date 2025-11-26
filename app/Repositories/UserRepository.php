<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    private $model;

    public function __construct( User $model ) {

        $this->model = $model;
    }
	
    public function getById( int $userId ): Collection {
        return $this->model->where( 'id', $userId )->get();
    }
	
	public function updatePublish( int $userId, int $publish ): Bool {
        return $this->model->where( 'id', $userId )
                           ->update( array ('publish' => $publish) );
    }
	
	public function getAllPaginated(String $filter): LengthAwarePaginator {		
        return $this->model
							->where(function($query) use ($filter) {
								if ( !is_null($filter) && $filter != '' ) {
									$query->orWhere('name', 'like', '%'.$filter.'%');
									$query->orWhere('email', 'like', '%'.$filter.'%');
								}
							})
							->orderBy('name', 'asc')
                           	->paginate( 20 );
    }
	
	public function updateUser( Int $id, Array $attributtes ): Bool {
        return $this->model->where( 'id', $id )
                           ->update( $attributtes );
    }
	
	public function getByMemberId( String $member_id ): Collection {
		return $this->model
							->where( 'member_id', '=', $member_id )
							->get();
    }
	
	public function add( Array $attributtes ): User {
        return $this->model->create( $attributtes );
    }

    public function update( Int $id, Array $attributtes ): Bool {
        return $this->model->where( 'id', $id )
                           ->update( $attributtes );
    }


}
