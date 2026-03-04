<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{Event, User};

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Event::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'max_participants' => 'required|integer|min:1',
        ];

        if ($user->isAdmin()) {
            $rules['status'] = 'nullable|in:Draft,PendingApproval,Approved,Rejected,Completed';
            $rules['scope'] = 'nullable|in:University,Public';
            $rules['university_id'] = 'nullable|required_if:scope,University|exists:universities,id';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Event title is required.',
            'end_datetime.after_or_equal' => 'End date must be after start date.',
        ];
    }
}
