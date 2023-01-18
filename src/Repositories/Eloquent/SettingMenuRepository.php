<?php

namespace Tripteki\SettingMenu\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tripteki\Repository\AbstractRepository;
use Tripteki\SettingMenu\Http\Resources\MenuResource;
use Tripteki\SettingMenu\Events\Placing;
use Tripteki\SettingMenu\Events\Placed;
use Tripteki\SettingMenu\Events\Unplacing;
use Tripteki\SettingMenu\Events\Unplaced;
use Tripteki\SettingMenu\Models\Admin\Detailmenu;
use Tripteki\Setting\Contracts\Repository\ISettingRepository;
use Tripteki\SettingMenu\Contracts\Repository\ISettingMenuRepository;
use Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;

class SettingMenuRepository extends AbstractRepository implements ISettingMenuRepository
{
    /**
     * @var \Tripteki\Setting\Contracts\Repository\ISettingRepository
     */
    protected $setting;

    /**
     * @var \Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository
     */
    protected $menudetail;

    /**
     * @param \Tripteki\Setting\Contracts\Repository\ISettingRepository $setting
     * @param \Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository $menudetail
     * @return void
     */
    public function __construct(ISettingRepository $setting, ISettingMenuDetailRepository $menudetail)
    {
        $this->setting = $setting;
        $this->menudetail = $menudetail;
    }

    /**
     * @return void
     */
    public function __destruct()
    {}

    /**
     * @param string $type
     * @param string|null $menu
     * @return string
     */
    protected function menu($type, $menu = null)
    {
        $menu = $menu ? $this->menudetail->type($type, $menu) : $menu;

        if ($menu) {

            return $menu;

        } else {

            return null;
        }
    }

    /**
     * @param array $querystring
     * @return mixed
     */
    public function all($querystring = [])
    {
        $user = $this->user; $content = null;

        $content = $user->load([ "menusHeadernavbar", "menusSidenavbar", ])->loadCount([ "menusHeadernavbar", "menusSidenavbar", ]);

        return new MenuResource($content);
    }

    /**
     * @param string $type
     * @param int|string $oldparent
     * @param int|string $oldchild
     * @param int|string $newparent
     * @param int|string $newchild
     * @return mixed
     */
    public function update($type, $oldparent, $oldchild, $newparent, $newchild)
    {
        $oldparent = $this->menu($type, $oldparent);
        $oldchild = $this->menu($type, $oldchild);
        $newparent = $this->menu($type, $newparent);
        $newchild = $this->menu($type, $newchild);

        $type = $this->menudetail->type($type);
        $content = null;

        DB::beginTransaction();

        try {

            $content = [ "user_id" => $this->user->id, ];

            call_user_func($type."::"."withoutGlobalScopes")->where(array_merge($content, [ "key" => $oldchild, "value" => $oldparent, ]))->delete();
            $content = call_user_func($type."::"."forceCreate", array_merge($content, [ "key" => $newchild, "value" => $newparent, ]));

            DB::commit();

            event(new Placed($content));

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @return mixed
     */
    public function delete($type, $identifier)
    {
        $this->setting->setUser($this->getUser());

        $identifier = $this->menudetail->type($type, $identifier);
        $type = $this->menudetail->type($type);
        $content = null;

        DB::beginTransaction();

        try {

            $content = $this->setting->setdown($identifier);
            $content->forceDelete();

            DB::commit();

            event(new Unplaced($content));

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param string $menu
     * @param string $element
     * @return mixed
     */
    public function attach($menu, $element)
    {
        $parentmenu = Str::replace(".".Str::afterLast($menu, "."), "", $menu);
        $childmenu = $menu;
        $content = null;

        if ($parentmenu === $childmenu) $content = $this->update($element, null, null, null, $childmenu);
        else $content = $this->update($element, $parentmenu, null, $parentmenu, $childmenu);

        return $content;
    }

    /**
     * @param string $menu
     * @param string $element
     * @return mixed
     */
    public function detach($menu, $element)
    {
        return $content = $this->delete($element, $menu);
    }

    /**
     * @param string|null $from
     * @param string|null $to
     * @param string $element
     * @return mixed
     */
    public function move(string|null $from, string|null $to, string $element)
    {
        $content = null;

        if ($from && ! $to) {

            return $content = $this->detach($from, $element);
        }

        if ($from && $to) {

            $this->detach($from, $element);

            $to = $to.".".Str::afterLast($from, ".");
        }

        return $content = $this->attach($to, $element);
    }
};
