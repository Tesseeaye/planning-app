<?php

namespace App\Http\Requests;

use App\Models\Lists;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreListsRequest extends FormRequest
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
                Rule::notIn(Lists::where('user_id', auth('sanctum')->user()->getAuthIdentifier())->pluck('name')->all())
            ],
            'project_slug' => 'required|string|exists:projects,slug'
        ];
    }
}