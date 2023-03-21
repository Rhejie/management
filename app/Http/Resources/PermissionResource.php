<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = str_replace('_',' ', $this->name);
        $pos = strpos($name, '-');
        $module = substr($name,0,$pos);
        $display = substr($name, ($pos+1));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'display' => $display,
            'module' => $module,
        ];
    }
}
