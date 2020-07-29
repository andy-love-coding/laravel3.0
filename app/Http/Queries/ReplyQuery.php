<?php

namespace App\Http\Queries;

use App\Models\Reply;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ReplyQuery extends QueryBuilder
{
    public function __construct()
    {
        // parent 指的是 QueryBuilder
        // Reply::query() 是 Reply 模型的查询构建器
        // 词句表示：构建了一个 Reply 模型的查询构建器
        parent::__construct(Reply::query());

        $this->allowedIncludes('user', 'topic');
    }
}