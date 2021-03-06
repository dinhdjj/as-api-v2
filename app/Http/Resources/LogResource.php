<?php

namespace App\Http\Resources;

use App\Traits\WithLoad;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    use WithLoad;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'loggable' => $this->when(
                !$this->whenLoaded('loggable')->isMissing(),
                function () {
                    switch (true) {
                            // case $this->loggable instanceof ABC:
                            //     return new ABCResource($this->loggable);
                        default:
                            return $this->loggable;
                    }
                }
            ),

            $this->mergeWhen(
                auth()->check() && request('_sensitive'),
                fn () => [
                    'hiddenData' => auth()->user()->can('readHiddenData', $this->resource) ? $this->hidden_data : null
                ],
            ),

            $this->mergeWhen(
                auth()->check() && request('_abilities'),
                fn () => [
                    'canReadHiddenData' => auth()->user()->can('readHiddenData', $this->resource),
                ],
            ),
        ]);
    }
}
