<?php

namespace App\Http\Controllers\Admin\Setting\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;
use App\Http\Requests\Admin\Settings\Menus\MenuIndexValidation;
use App\Http\Requests\Admin\Settings\Menus\MenuShowValidation;
use App\Http\Requests\Admin\Settings\Menus\MenuStoreValidation;
use App\Http\Requests\Admin\Settings\Menus\MenuUpdateValidation;
use App\Http\Requests\Admin\Settings\Menus\MenuDestroyValidation;
use Tripteki\Helpers\Http\Controllers\Controller;

class MenuAdminController extends Controller
{
    /**
     * @var \Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository
     */
    protected $menuAdminRepository;

    /**
     * @param \Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository $menuAdminRepository
     * @return void
     */
    public function __construct(ISettingMenuDetailRepository $menuAdminRepository)
    {
        $this->menuAdminRepository = $menuAdminRepository;
    }

    /**
     * @OA\Get(
     *      path="/admin/bars/{bar}/menus",
     *      tags={"Admin Menu"},
     *      summary="Index",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="bar",
     *          schema={"type": "string", "enum": {"headernavbar", "sidenavbar"}},
     *          description="Menu's Bar."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="limit",
     *          description="Menu's Pagination Limit."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="current_page",
     *          description="Menu's Pagination Current Page."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="order",
     *          description="Menu's Pagination Order."
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="filter[]",
     *          description="Menu's Pagination Filter."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Menus\MenuIndexValidation $request
     * @param string $bar
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MenuIndexValidation $request, $bar)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        $data = $this->menuAdminRepository->all($bar);

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Get(
     *      path="/admin/bars/{bar}/menus/{menu}",
     *      tags={"Admin Menu"},
     *      summary="Show",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="bar",
     *          schema={"type": "string", "enum": {"headernavbar", "sidenavbar"}},
     *          description="Menu's Bar."
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="menu",
     *          description="Menu's Menu."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Menus\MenuShowValidation $request
     * @param string $bar
     * @param string $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MenuShowValidation $request, $bar, $menu)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 200;

        $data = $this->menuAdminRepository->get($bar, $menu);

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Post(
     *      path="/admin/bars/{bar}/menus",
     *      tags={"Admin Menu"},
     *      summary="Store",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="bar",
     *          schema={"type": "string", "enum": {"headernavbar", "sidenavbar"}},
     *          description="Menu's Bar."
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="menu",
     *                      type="string",
     *                      description="Menu's Menu."
     *                  ),
     *                  @OA\Property(
     *                      property="category",
     *                      type="string",
     *                      description="Menu's Category."
     *                  ),
     *                  @OA\Property(
     *                      property="icon",
     *                      type="string",
     *                      description="Menu's Icon."
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Menu's Title."
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Menu's Description."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Menus\MenuStoreValidation $request
     * @param string $bar
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuStoreValidation $request, $bar)
    {
        $form = $request->validated(); $menu = $form["menu"]; $form = collect($form)->except([ "bar", "menu", ])->toArray();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->create($bar, $menu, $form);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Put(
     *      path="/admin/bars/{bar}/menus/{menu}",
     *      tags={"Admin Menu"},
     *      summary="Update",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="bar",
     *          schema={"type": "string", "enum": {"headernavbar", "sidenavbar"}},
     *          description="Menu's Bar."
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="menu",
     *          description="Menu's Menu."
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="category",
     *                      type="string",
     *                      description="Menu's Category."
     *                  ),
     *                  @OA\Property(
     *                      property="icon",
     *                      type="string",
     *                      description="Menu's Icon."
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Menu's Title."
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Menu's Description."
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Menus\MenuUpdateValidation $request
     * @param string $bar
     * @param string $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MenuUpdateValidation $request, $bar, $menu)
    {
        $form = collect($request->validated())->except([ "bar", "menu", ])->toArray();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->update($bar, $menu, $form);

        if ($data) {

            $statecode = 201;
        }

        return iresponse($data, $statecode);
    }

    /**
     * @OA\Delete(
     *      path="/admin/bars/{bar}/menus/{menu}",
     *      tags={"Admin Menu"},
     *      summary="Destroy",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="bar",
     *          schema={"type": "string", "enum": {"headernavbar", "sidenavbar"}},
     *          description="Menu's Bar."
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="menu",
     *          description="Menu's Menu."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success."
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found."
     *      )
     * )
     *
     * @param \App\Http\Requests\Admin\Settings\Menus\MenuDestroyValidation $request
     * @param string $bar
     * @param string $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MenuDestroyValidation $request, $bar, $menu)
    {
        $form = $request->validated();
        $data = [];
        $statecode = 202;

        $data = $this->menuAdminRepository->delete($bar, $menu);

        if ($data) {

            $statecode = 200;
        }

        return iresponse($data, $statecode);
    }
};
