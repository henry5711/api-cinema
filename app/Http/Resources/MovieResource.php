<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'attributes' => [
                'name'        => $this->resource->name,
                'duration'    => $this->resource->duration,
                'gender_id'           => $this->resource->gender_id,
                'description' => $this->resource->description,
                'deleted_at'     => $this->resource->deleted_at,
                'created_at'     => $this->resource->created_at,
                'updated_at'     => $this->resource->updated_at,

            ],
            'relationships' => [
                'gender' => $this->whenLoaded('gender', function() {
                    return GenderResource::make($this->resource->gender);
                })
            ],
        ];
    }
}
