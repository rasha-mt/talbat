<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function toData()
    {
        return json_decode($this->toJson(), true);
    }

    public function additional(array $data)
    {
        $this->additional = array_merge_recursive($this->additional, $data);

        return $this;
    }

    public function additionalMeta($meta = [])
    {
        return $this->additional([
            'meta' => $meta ?? [],
        ]);
    }

    public function whenLoadedAs(string $relationship, string $resourceClass)
    {
        return $this->whenLoaded($relationship, function () use ($relationship, $resourceClass) {
            return new $resourceClass($this->resource->$relationship);
        });
    }
}
