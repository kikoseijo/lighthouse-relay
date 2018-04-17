<?php

namespace App\Repositories;

use App\Repositories\UserRepository as Contract;
use App\Models\User;

class UserRepository extends Contract
{
    protected $query;
    protected $attrsFilter = ['email'];

    public function model()
    {
        return User::class;
    }

    public function withPagination($perPage, $request)
    {
        $query = $this->model::orderBy('id', 'desc');
        $qTerm = $request->filled('q') ? $request->get('q') : null;

        if ($qTerm) {
            $query->where('name', 'like', '%' . $qTerm . '%');
            foreach ($this->attrsFilter as $key) {
                $query->orWhere($key, 'like', '%' . $qTerm . '%');
            }
        }

        return $query->paginate($perPage);
    }

    /**
     * @param  Illuminate\Http\Request $request
     * @return Pagination|Collection|Array
     */
    public function withRelationships($request)
    {
        $search_term = $request->input('q') ?: '';

        $queryBuilder = $this->model::where('id','>', 0);

        return $this->paginateIf($queryBuilder->get());

    }



}
