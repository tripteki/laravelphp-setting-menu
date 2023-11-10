<?php

namespace Tripteki\SettingMenu\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class MenudetailResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            "bar" => $this->bar,
            "menu" => $this->menu,
            "category" => $this->category,
            "icon" => $this->icon,
            "title" => $this->title,
            "description" => $this->description,
        ];
    }
};
