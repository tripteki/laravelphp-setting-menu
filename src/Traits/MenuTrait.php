<?php

namespace Tripteki\SettingMenu\Traits;

use Tripteki\SettingMenu\Models\Headernavbar;
use Tripteki\SettingMenu\Models\Sidenavbar;

trait MenuTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menusHeadernavbar()
    {
        return $this->hasMany(Headernavbar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menusSidenavbar()
    {
        return $this->hasMany(Sidenavbar::class);
    }
};
