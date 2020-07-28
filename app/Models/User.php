<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    use  Traits\LastActivedAtHelper;
    use  Traits\ActiveUserHelper;
    use  HasRoles;
    use  MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，其他频道如 Email、短信、Slack 都略过
        if (method_exists ($instance, 'toDatabase')) {
            $this->increment('notification_count', 1);
        }

        $this->laravelNotify($instance);

    }

    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar', 'weixin_openid', 'weixin_unionid',
    ];

    protected $hidden = [
        'password', 'remember_token', 'weixin_openid', 'weixin_unionid',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    // Eloquent 修改器
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，则认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 这么做，是要排除「修改密码时已经加密过的密码，再加密」
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! \Str::startsWith($path, 'http')) {
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }

    // getJWTIdentifier 返回了 User 的 id
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // getJWTCustomClaims 是我们需要额外在 JWT 载荷中增加的自定义内容，这里返回空数组
    public function getJWTCustomClaims()
    {
        return [];
    }

}
