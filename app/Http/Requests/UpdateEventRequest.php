<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      return $this->user()->can('update', $this->event);       
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
            'status' => 'required|in:Draft,PendingApproval,Approved,Rejected,Completed',
            'scope' => 'required|in:Public,University',
            'university_id' => 'nullable|required_if:scope,University|exists:universities,id',
        ];
    }
}
