<?php

namespace Tripteki\SettingMenu\Events;

use Illuminate\Queue\SerializesModels as SerializationTrait;

class Placed
{
    use SerializationTrait;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @param mixed $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
};
