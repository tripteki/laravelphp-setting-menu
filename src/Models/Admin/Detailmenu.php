<?php

namespace Tripteki\SettingMenu\Models\Admin;

use Tripteki\SettingMenu\Scopes\MenuStrictScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Detailmenu extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * @var string
     */
    protected $table = "menus";

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = "string";

    /**
     * @var string
     */
    protected $primaryKey = "menuable_id";

    /**
     * @var array
     */
    protected $fillable = [ "menuable_type", "menuable_id", "category", "icon", "title", "description", ];

    /**
     * @var array
     */
    protected $hidden = [ "menuable_type", "menuable_id", ];

    /**
     * @var array
     */
    protected $appends = [ "bar", "menu", ];

    /**
     * @return string
     */
    public function getBarAttribute()
    {
        return Str::lower(Str::afterLast($this->menuable_type, "\\"));
    }

    /**
     * @return string
     */
    public function getMenuAttribute()
    {
        return Str::after(Str::replaceFirst(MenuStrictScope::space(null), "", $this->menuable_id), ".");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menuable()
    {
        return $this->morphTo();
    }
};
