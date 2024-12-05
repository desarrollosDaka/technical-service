<?php

namespace App\Http\Requests\Media;

use App\Enums\Media\MediaModel;
use App\Models\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) Gate::authorize('create', Media::class);
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
                Rule::in(array_map(fn($enum) => $enum->name, MediaModel::cases()))
            ],
            'model_id' => 'required',
            'file' => 'required|file|image|max:4096',
            'collection_name' => 'required',
        ];
    }
}
