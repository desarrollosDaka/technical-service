<?php

namespace App\Http\Requests\Ticket;

use App\Enums\Ticket\Status as TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) Gate::authorize('update', $this->ticket);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|max:255',
            'diagnosis_date' => 'nullable|date',
            'diagnosis_detail' => 'nullable',
            'customer_name' => 'nullable|max:255',
            'solution_date' => 'nullable|date',
            'solution_detail' => 'nullable',
            'status' => [
                'nullable',
                Rule::enum(TicketStatus::class)
            ],
            'meta' => 'nullable|json',
        ];
    }
}
