<?php

namespace Juzaweb\PaymentMethod\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Juzaweb\PaymentMethod\Models\PaymentMethod;

/**
 * @property-read PaymentMethod $resource
 */
class PaymentMethodResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'active' => (bool) $this->resource->active,
        ];
    }
}
