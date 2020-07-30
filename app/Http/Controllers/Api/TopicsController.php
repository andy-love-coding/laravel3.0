<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\User;
use App\Http\Queries\TopicQuery;

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

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();
        return response(null, 204);
    }

    public function index(Request $request, Topic $topic, TopicQuery $query)
    {
        // $query 是 Topic 模型的查询构建器
        // $query = $topic->query();

        // if ($categoryId = $request->category_id) {
        //     $query->where('category_id', $categoryId);
        // }

        // $topics = $query
        //         ->with('user', 'category') // 预加载
        //         ->withOrder($request->order)
        //         ->paginate(20);

        // $topics = QueryBuilder::for(Topic::class)
        //     ->allowedIncludes('user', 'user.roles','category')
        //     ->allowedFilters([
        //         'title',
        //         AllowedFilter::exact('category_id'),
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();

        $topics = $query->paginate();
        
        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request, User $user, TopicQuery $query)
    {
        // $query = $user->topics()->getQuery();

        // $topics = QueryBuilder::for($query)
        //     ->allowedIncludes('user','user.roles', 'category')
        //     ->allowedFilters([
        //         'title',
        //         AllowedFilter::exact('category_id'),
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();
        
        $topics = $query->where('user_id', $user->id)->paginate();

        return TopicResource::collection($topics);
    }

    // 路由模型绑定
    // public function show(Topic $topic)
    // {
    //     return new TopicResource($topic);
    // }

    // 不使用路由模型绑定
    public function show($topicId, TopicQuery $query)
    {
        // $topic = QueryBuilder::for(Topic::class)
        //     ->allowedIncludes('user', 'category')
        //     ->findOrFail($topicId);

        $topic = $query->findOrFail($topicId);

        return new TopicResource($topic);
    }  

}
