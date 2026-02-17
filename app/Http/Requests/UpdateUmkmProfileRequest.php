<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUmkmProfileRequest extends StoreUmkmProfileRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        
        // Update unique rules for existing record
        $umkmProfileId = $this->route('umkmProfile')->id;
        
        $rules['name'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('umkm_profiles', 'name')->ignore($umkmProfileId)
        ];
        
        $rules['slug'] = [
            'nullable',
            'string',
            'max:255',
            Rule::unique('umkm_profiles', 'slug')->ignore($umkmProfileId)
        ];
        
        // Make thumbnail optional on update
        $rules['thumbnail'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        
        return $rules;
    }
}