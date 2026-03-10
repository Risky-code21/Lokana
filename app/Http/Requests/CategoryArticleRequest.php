<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryArticleRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $id = $this->route('category_article');
        
        // Pastikan ID tidak null dan valid
        $id = $id ? $id->id : null;
        
        $rules = [
            'name' => 'required|string|max:255|unique:category_articles,name',
            'description' => 'required|string'
        ];

        // Jika ini adalah request update (PUT/PATCH)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'required|string|max:255|unique:category_articles,name,' . $id;
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori harus diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'description.required' => 'Deskripsi harus diisi.'
        ];
    }
}