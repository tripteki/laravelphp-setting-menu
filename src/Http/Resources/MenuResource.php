<?php

namespace Tripteki\SettingMenu\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            "menus_headernavbar_count" => $this->whenCounted("menusHeadernavbar"),
            "menus_sidenavbar_count" => $this->whenCounted("menusSidenavbar"),
            "menus_headernavbar" => $this->whenLoaded("menusHeadernavbar"),
            "menus_sidenavbar" => $this->whenLoaded("menusSidenavbar"),
        ];
    }
};
