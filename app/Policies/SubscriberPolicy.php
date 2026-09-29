<?php

namespace App\Policies;

use App\Models\User;

class SubscriberPolicy extends AdminPolicy
{
    /*
     * Subscribers arrive from the public newsletter form. There is no reason
     * for anyone to hand-author one, so creation stays closed even for
     * admins; edits and deletes (unsubscribes, data-erasure requests) remain.
     */
    public function create(User $user): bool
    {
        return false;
    }
}
