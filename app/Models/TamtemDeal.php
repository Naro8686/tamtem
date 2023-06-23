<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamtemDeal extends Model
{
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizations()
    {
        return $this->hasMany(\App\Models\TamtemOrganization::class, 'okved', 'tamtem_organization_okved');
    }
}
