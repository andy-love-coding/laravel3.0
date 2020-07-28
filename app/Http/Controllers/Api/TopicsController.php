<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;

class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        // 注意不要使用有 manage_contents 权限的用户，也就是 id 为 1 ，2 的用户，
        // 他们有管理内容的权限，所以可以修改任何人的话题。
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return new TopicResource($topic);
    }
}
