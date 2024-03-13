<?php

namespace App\Http\Requests;

use Http\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => ['image', 'mimes:png,jpg,jpeg'],
            'nickname' => ['required', 'min:1', 'max:500', 'unique:players,nickname'],
        ];
    }
}
