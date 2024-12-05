<?php

namespace App\Http\Requests\Media;

use App\Enums\Media\MediaModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
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
            'model_type' => [
                'required',
                Rule::in(array_map(fn($enum) => $enum->name, MediaModel::cases())),
            ],
            'model_id' => 'required',
            'collection_name' => 'nullable',
        ];
    }
}
