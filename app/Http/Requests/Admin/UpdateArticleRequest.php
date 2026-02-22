<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     *  Memastikan hanya admin saja yang bisa melakukan request untuk update article ini
     *
     *  @param User $user
     *  @return boolean
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    /**
     *  Syarat supaya request dapat diterima
     * 
     *  @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'category_id'       => ['required', 'exists:category_articles,id'],
            'short_description' => ['required', 'string', 'max:500'],
            'content'           => ['required'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
