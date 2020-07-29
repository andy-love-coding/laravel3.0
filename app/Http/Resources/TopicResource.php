<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        // 通过 whenLoaded 判断是否已经预加载了 user 和 category，
        // 如果有，则使用对应的 Resource 处理并返回数据。
        $data['user'] = new UserResource($this->whenLoaded('user'));
        $data['category'] = new CategoryResource($this->whenloaded('category'));

        return $data;
    }
}
