<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ContactSubmissionPolicy extends AdminPolicy
{
    /*
     * Submissions arrive from the public contact form and are a record of what
     * a visitor wrote. Authoring one by hand is never legitimate.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /*
     * What a visitor wrote is evidence. Rewriting the body of a received
     * message, or deleting it, destroys the record - the resource exposes only
     * a read-only view page, and these abilities back that up.
     */
    public function update(User $user, ?Model $model = null): bool
    {
        return false;
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
