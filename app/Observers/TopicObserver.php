<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    // 数据写入数据库之前
    public function saving(Topic $topic)
    {
        // 使用「HTMLPurifier扩展」的 clean() 方法过滤用户提交内容，第二个参数是 config/purifier 中的配置项
        $topic->body = clean($topic->body, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->body);
    }
}