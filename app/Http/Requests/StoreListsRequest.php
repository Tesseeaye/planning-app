<?php

namespace App\Http\Requests;

use App\Models\Lists;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreListsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
                Rule::notIn(Lists::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->pluck('name')->all())
            ],
            'board_slug' => 'required|string|exists:boards,slug'
        ];
    }
}