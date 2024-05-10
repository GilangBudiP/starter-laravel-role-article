<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $appends = ['category', 'action'];

    public function getCategoryAttribute()
    {
        return explode('.', $this->name)[0];
    }

    public function getActionAttribute()
    {
        return explode('.', $this->name)[1] ?? null;
    }
}
