<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfluencerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'instagram_username' => 'required|string|max:255|unique:influencers',
            'followers_qty' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
        ];
    }
}
