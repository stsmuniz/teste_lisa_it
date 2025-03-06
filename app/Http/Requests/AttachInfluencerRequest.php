<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachInfluencerRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can implement authorization logic here if needed
    }

    public function rules()
    {
        return [
            'influencer_id' => 'required|exists:influencers,id',
        ];
    }
}
