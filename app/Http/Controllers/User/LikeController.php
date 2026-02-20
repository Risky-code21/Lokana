<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($type, $id)
    {
        // 1. Validasi Type (Security)
        // Pastikan 'article' atau 'comment' terdaftar di morphMap
        $modelClass = Relation::getMorphedModel($type);

        if (!$modelClass) {
            abort(404, 'Tipe konten tidak valid.');
        }

        // 2. Cari Model
        $model = $modelClass::findOrFail($id);

        // 3. Panggil Trait (Logic ada di Trait HasLikes)
        $status = $model->toggleLike(Auth::id());

        // 4. Return
        $message = $status === 'liked' ? 'Berhasil menyukai.' : 'Batal menyukai.';

        // Gunakan fragment agar scroll tidak loncat ke atas
        return back()
            ->with('success', $message)
            ->withFragment('like-btn-' . $model->id);
    }
}
