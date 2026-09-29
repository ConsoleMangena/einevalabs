<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderPolicy extends AdminPolicy
{
    /*
     * Orders are a financial record created by customers at checkout. Nothing
     * in the admin should be able to author, edit or delete one - corrections
     * go through a refund, which is a status change, not an edit.
     */
    public function create(User $user): bool
    {
        return false;
    }

    // Signatures must match AdminPolicy's `?Model $model = null`: PHP checks
    // subclass compatibility at compile time, and a narrowed parameter type
    // here is a fatal error, not a policy denial.
    public function update(User $user, ?Model $model = null): bool
    {
        return (bool) $user->is_admin;
    }

    public function delete(User $user, ?Model $model = null): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
