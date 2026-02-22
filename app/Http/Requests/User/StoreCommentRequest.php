<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     *  Function untuk memastikan siapa saja yang bisa mengirim request ke suatu function jika dia mengimplementasikan parameter class ini, untuk saat ini create atau store comment kita berikan nilai true karena logika perizinan siapa yang boleh membuat komentar itu sudah ditangani oleh middleware auth
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
            'parent_id' => ['nullable', 'exists:comments,id'],
            'reply_target_id' => ['nullable', 'exists:comments,id'],
        ];
    }
}
