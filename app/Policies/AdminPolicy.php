<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Base for the Filament resource policies.
 *
 * The panel had no authorization at all: `canAccessPanel()` is now the outer
 * gate, and these policies are the inner one, so a user who is ever granted
 * panel access without full rights still cannot read customer data.
 *
 * Note the `?Model $model = null` on the per-record abilities. Laravel's
 * Gate resolves `view($user, $post)` and Filament always passes the record,
 * so a single-argument signature would raise an ArgumentCountError the first
 * time an admin clicked View or Edit.
 */
abstract class AdminPolicy
{
    /**
     * Administrative screens hold personal data - contact messages, subscriber
     * addresses, customer orders - so nothing is readable without the flag.
     */
    public function viewAny(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    public function view(User $user, ?Model $model = null): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    public function update(User $user, ?Model $model = null): bool
    {
        return (bool) $user->is_admin;
    }

    public function delete(User $user, ?Model $model = null): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Bulk actions in a Filament table are authorised per row, so the hook has
     * to exist or the bulk delete silently bypasses the check.
     */
    public function deleteAny(User $user): bool
    {
        return $this->delete($user);
    }

    /**
     * Bulk "restore"/"force delete" hooks, for the same reason as deleteAny().
     */
    public function restoreAny(User $user): bool
    {
        return $this->update($user);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $this->delete($user);
    }
}
