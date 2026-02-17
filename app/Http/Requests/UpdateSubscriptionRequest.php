<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // GANTI jadi true
    }

    public function rules(): array
    {
        return [
            'admin_notes' => 'nullable|string',
            'verified_at' => 'nullable|date',
            'verified_by' => 'nullable|exists:users,id'
        ];
    }
}