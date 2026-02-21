<?php


namespace App\Http\Controllers\User;

use App\Events\LikeToggled;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request, $type, $slug)
    {
        $modelClass = Relation::getMorphedModel($type);

        if (!$modelClass) {
            abort(404, 'Tipe konten tidak valid.');
        }

        $instance = new $modelClass;
        $searchColumn = in_array('slug', $instance->getFillable()) ? 'slug' : 'id';

        $model = $modelClass::where($searchColumn, $slug)
            ->when(is_numeric($slug) && $searchColumn !== 'id', function ($q) use ($slug) {
                $q->orWhere('id', $slug);
            })
            ->firstOrFail();

        $status = $model->toggleLike(Auth::id());

        // 👇 SOLUSI 1: Paksa Laravel menghitung ulang dari Database agar tidak basi!
        $freshLikesCount = $model->likes()->count();

        if ($status) {
            // Kirim angka yang sudah FRESH ke Reverb
            // 👇 SOLUSI 2: Gunakan broadcast()->toOthers()
            broadcast(new LikeToggled($freshLikesCount, $type, $slug))->toOthers();
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                // Kirimkan jumlah like terbaru ke response Fetch
                'likes_count' => $freshLikesCount
            ]);
        }
    }
}
