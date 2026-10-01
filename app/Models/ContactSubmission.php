<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department',
        'subject',
        'message',
    ];

    /**
     * The department slug a submission arrived against, or null when the
     * visitor did not choose one.
     */
    public function departmentLabel(): ?string
    {
        if ($this->department === null) {
            return null;
        }

        return config('departments.'.$this->department.'.label');
    }
}
