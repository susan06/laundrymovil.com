<?php

namespace App\Repositories\User;

use App\User;
use App\Repositories\Repository;

class EloquentUser extends Repository implements UserRepository
{
	 /**
     * Fields attributes
     *
     * @var array
     */
    protected $attributes = ['name', 'lastname', 'email', 'status'];

    /**
     * EloquentUser constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user, $this->attributes);
    }

    /**
     * Paginate and search
     *
     * return the result paginated for the take value and with the attributes.
     *
     * @param int $take
     * @param string $search
     *
     * @return mixed
     *
     */
    public function paginate_search($take = 10, $search = null)
    {
        if ($search) {
            $result = User::where( function ($q) use($search) {
                foreach ($this->attributes as $attribute) {
                    $q->orwhere($attribute, "like", "%{$search}%");
                }
                $q->whereHas('role', function($qu) use($search) {
                    $qu->where('name', "like", "%{$search}%");
                    $qu->where('display_name', "like", "%{$search}%");
                });
            })->paginate($take)->appends(['search' => $search]);
        } else {
            $result = $this->model->paginate($take);

        }

        return $result;
    }

}