<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // GANTI jadi true biar bisa dipake
    }

    public function rules(): array
    {
        return [
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
}