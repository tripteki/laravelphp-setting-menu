<?php

namespace Tripteki\SettingMenu\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Tripteki\SettingMenu\Models\Headernavbar;
use Tripteki\SettingMenu\Models\Sidenavbar;
use Tripteki\SettingMenu\Models\Admin\Detailmenu;
use Tripteki\SettingMenu\Scopes\MenuStrictScope;
use Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;
use Tripteki\RequestResponseQuery\QueryBuilder;

class SettingMenuDetailRepository implements ISettingMenuDetailRepository
{
    /**
     * @param string $context
     * @param string|null $menu
     * @return string
     * @throws \InvalidArgumentException
     */
    public function type($context, $menu = null)
    {
        $contexts =
        [
            (app(Headernavbar::class)->space) => Headernavbar::class,
            (app(Sidenavbar::class)->space) => Sidenavbar::class,
        ];

        if ($menu) {

            foreach ($contexts as $key => $value) {

                $contexts[$key] = MenuStrictScope::space($key);
            }
        }

        $type = @$contexts[$context] ?: null;

        if ($type && ! $menu) {

            return $type;
        }
        if ($type && $menu) {

            return $type.".".$menu;

        } else {

            throw new \InvalidArgumentException("Menu type is not valid.");
        }
    }

    /**
     * @param int|string $type
     * @param array $querystring
     * @return mixed
     */
    public function all($type, $querystring = [])
    {
        $type = $this->type($type);
        $querystringed =
        [
            "limit" => $querystring["limit"] ?? request()->query("limit", 10),
            "current_page" => $querystring["current_page"] ?? request()->query("current_page", 1),
        ];
        extract($querystringed);

        $content = QueryBuilder::for(Detailmenu::where("menuable_type", $type))->
        defaultSort("category")->
        allowedSorts([ "category", "icon", "title", "description", ])->
        allowedFilters([ "category", "icon", "title", "description", ])->
        paginate($limit, "*", "current_page", $current_page)->appends(empty($querystring) ? request()->query() : $querystringed);

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @param array $querystring
     * @return mixed
     */
    public function get($type, $identifier, $querystring = [])
    {
        $identifier = $this->type($type, $identifier);
        $type = $this->type($type);
        $content = Detailmenu::where([ "menuable_type" => $type, "menuable_id" => $identifier, ])->firstOrFail();

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function update($type, $identifier, $data)
    {
        $identifier = $this->type($type, $identifier);
        $type = $this->type($type);
        $content = Detailmenu::where([ "menuable_type" => $type, "menuable_id" => $identifier, ])->firstOrFail();

        DB::beginTransaction();

        try {

            $content->fill($data);

            $content->save();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function create($type, $identifier, $data)
    {
        $identifier = $this->type($type, $identifier);
        $type = $this->type($type);
        $content = null;

        DB::beginTransaction();

        try {

            $content = Detailmenu::firstOrCreate(array_merge($data, [ "menuable_type" => $type, "menuable_id" => $identifier, ]));

            DB::commit();

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
        $identifier = $this->type($type, $identifier);
        $type = $this->type($type);
        $content = Detailmenu::where([ "menuable_type" => $type, "menuable_id" => $identifier, ])->firstOrFail();

        DB::beginTransaction();

        try {

            $content->delete();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }
};
