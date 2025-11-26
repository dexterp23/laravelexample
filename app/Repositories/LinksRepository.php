<?php

namespace App\Repositories;

use App\Models\Links;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class LinksRepository
{
    private $model;

    public function __construct( Links $model ) {

        $this->model = $model;
    }

    public function getById( int $ID_users, int $id ): Collection {
		return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
							->get();
    }

    public function getAllPaginated(String $filter, int $vendor_id, int $group_id, int $status): LengthAwarePaginator {	
        $ID_users = Auth::id();
        return $this->model
							->addSelect('links.*', 'vendors.name as vendors_name', 'groups.name as groups_name', 'domains.url as domains_url')
							->where( 'links.ID_users', $ID_users )
							->where(function($query) use ($filter) {
								if ( !is_null($filter) && $filter != '' ) {
									$query->orWhere('links.name', 'like', '%'.$filter.'%');
								}
							})
							->where(function($query) use ($vendor_id) {
								if ( !is_null($vendor_id) && $vendor_id != '' ) {
									$query->orWhere('vendor_id', '=', $vendor_id);
								}
							})
							->where(function($query) use ($group_id) {
								if ( !is_null($group_id) && $group_id > 0 ) {
									$query->orWhere('group_id', '=', $group_id);
								}
							})
							->where(function($query) use ($status) {
								if ( !is_null($status) && $status > 0 ) {
									$query->orWhere('status', '=', $status);
								}
							})
							->leftJoin('vendors', 'vendors.id', '=', 'links.vendor_id')
							->leftJoin('groups', 'groups.id', '=', 'links.group_id')
							->leftJoin('domains', 'domains.id', '=', 'links.domain_id')
							->orderBy('links.name', 'asc')
                           	->paginate( 20 );
    }
	
	public function add( Array $attributtes ): Links {
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
	
	public function chkTextLink( int $ID_users, int $id, String $text_link ): Collection {
		return $this->model
							->where( 'id', '!=', $id )
							->where( 'text_link', '=', $text_link )
							->where( 'ID_users', $ID_users )
							->get();
    }
	
	public function getByTextLink( int $ID_users, String $text_link ): Collection {
		return $this->model
							->where( 'text_link', '=', $text_link )
							->where( 'ID_users', $ID_users )
							->get();
    }
	
	public function updateClick( int $ID_users, int $id, String $field, int $value ): Bool {
        return $this->model
							->where( 'id', $id )
							->where( 'ID_users', $ID_users )
							->increment($field, $value);
    }
	
}
