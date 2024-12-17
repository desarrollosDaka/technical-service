<?php

namespace App\Http\Requests\TechnicalVisit;

use App\Models\TechnicalVisit;
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
        return (bool) Gate::authorize('create', TechnicalVisit::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'visit_date' => 'required|date',
            'ticket_id' => [
                'required',
                Rule::exists('tickets', 'id')->where('technical_id', $this->user()->getKey()),
            ],
            'observations' => 'nullable',
            'meta' => 'nullable|json',
            'services' => 'nullable|array',
        ];
    }
}
