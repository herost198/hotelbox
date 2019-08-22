<?php

namespace App\Policies;

use App\Model\AdminModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */


    public function __construct()
    {

    }
    public function view(AdminModel $user){
        return $user->permission === 'admin';
    }
}
