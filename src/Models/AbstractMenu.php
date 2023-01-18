<?php

namespace Tripteki\SettingMenu\Models;

use Tripteki\SettingMenu\Scopes\MenuStrictScope;
use Tripteki\Helpers\Contracts\AuthModelContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractMenu extends Model
{
    use \Awobaz\Compoships\Compoships;

    const CREATED_AT = null;
    const UPDATED_AT = "updated_at";

    /**
     * @var string
     */
    protected $table = "settings";

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
    protected $primaryKey = "key";

    /**
     * @var array
     */
    protected $fillable = [ "key", "value", ];

    /**
     * @var array
     */
    protected $hidden = [ "key", "value", "user_id", ];

    /**
     * @var array
     */
    protected $appends = [ "menus_id", "menus_count", ];

    /**
     * @var array
     */
    protected $with = [ "menus", "detail", ];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MenuStrictScope());
    }

    /**
     * @return string
     */
    public function getMenusIdAttribute()
    {
        return MenuStrictScope::space(Str::before(Str::after($this->key, MenuStrictScope::space(null)), ".").".".Str::afterLast($this->key, "."));
    }

    /**
     * @return int
     */
    public function getMenusCountAttribute()
    {
        return $this->menus()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menus()
    {
        $key = foreignKeyName(app(AuthModelContract::class));

        return $this->hasMany(static::class, [ "value", $key, ], [ "key", $key, ])->withoutGlobalScope(MenuStrictScope::class)->with("menus");
    }
};
