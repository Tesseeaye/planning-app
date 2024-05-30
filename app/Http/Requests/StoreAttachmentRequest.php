<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreAttachmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                File::image()
                    ->min('1kb')
                    ->max('12mb')
                    ->dimensions(Rule::dimensions()->maxWidth(3840)->maxHeight(2160)),
                Rule::requiredIf($this->isMethod('post'))
            ],
            'alt_text' => [
                'string',
                'max:255',
                Rule::requiredIf($this->isMethod('put'))
            ],
            'card_slug' => [
                'string',
                'exists:cards,slug',
                Rule::requiredIf($this->isMethod('post'))
            ],
        ];
    }
}
