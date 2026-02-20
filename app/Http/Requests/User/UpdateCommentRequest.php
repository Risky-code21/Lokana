<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    /**
     *  Function untuk memastikan siapa saja yang bisa mengirim request ke suatu function jika dia mengimplementasikan parameter class ini, untuk saat ini update comment kita berikan nilai true karena logika perizinan siapa saja yang bisa mengedit itu dipindahkan kedalam policy
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     *  Aturan yang harus dipenuhi oleh request sebelum dapat mengeksekusi function yang menggunakan class ini sebagai param
     *
     *  @return array
     */
    public function rules(): array
    {
        return [
            'content' => ['string', 'max:1000'],
        ];
    }
}
