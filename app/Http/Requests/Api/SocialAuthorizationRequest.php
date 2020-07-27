<?php

namespace App\Http\Requests\Api;

class SocialAuthorizationRequest extends FormRequest
{
    public function rules()
    {
        // 客户端要么提交授权码（code），要么提交 access_token 和 openid
        $rules = [
            'code' => 'required_without:access_token|string',
            'access_token' => 'required_without:code|string',
        ];

        if ($this->social_type == 'weixin' && !$this->code) {
            $rules['openid'] = 'required|string';
        }

        return $rules;
    }
}
