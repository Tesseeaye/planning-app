<?php

namespace App\Http\Requests;

use App\Models\Card;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::notIn(Card::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->pluck('name')->all())
            ],
            'content' => 'string|max:2000',
            'list_slug' => 'required|string|exists:lists,slug'
        ];
    }
}