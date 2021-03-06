<?php

namespace App\Http\Resources;

use App\Models\Account;
use App\Models\AccountInfo;
use App\Traits\WithLoad;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountTypeResource extends JsonResource
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
            'creator' => new UserResource($this->whenLoaded('creator')),
            'updater' => new UserResource($this->whenLoaded('updater')),
            'users' => UserResource::collection($this->whenLoaded('users')),

            'tags' =>  TagResource::collection($this->whenLoaded('tags')),

            'logs' =>  LogResource::collection($this->whenLoaded('logs')),

            'accountInfos' => AccountInfoResource::collection($this->whenLoaded('accountInfos')),

            $this->mergeWhen(
                auth()->check() && request('_abilities'),
                fn () => [
                    'canUpdate' => auth()->user()->can('update', $this->resource),
                    'canDelete' => auth()->user()->can('delete', $this->resource),
                    'canCreateAccountInfo' => auth()->user()->can('create', [AccountInfo::class, $this->resource]),
                    'canCreateAccount' => auth()->user()->can('create', [Account::class, $this->resource]),
                ],
            ),
        ]);
    }
}
