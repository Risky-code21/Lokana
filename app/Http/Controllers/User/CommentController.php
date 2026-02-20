<?php

namespace App\Http\Controllers\User;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreCommentRequest;
use App\Http\Requests\User\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     *  Function untuk upload komentar menggunakan sistem realtime websocket dengan dibantu laravel reverb
     *
     * `@param StoreCommentRequest $request
     * `@param string $type
     * `@param string $slug
     *` @return void harusnya response json, tapi karena terhalang blok if
     */
    public function store(StoreCommentRequest $request, string $type, string $slug)
    {
        // Type dari model, karena kita akan mencari setiap model relative yang memiliki relasi polymorphic, maka dari itu kita perlu merubah nama pemanggilan model seperti yang kita rubah didalam service provider kita
        $modelClass = Relation::getMorphedModel($type);

        // Jika tidak ada model yang tersedia sesuai type kembalikan page 404
        if (!$modelClass) abort(404, 'Model type not found');

        // Dapatkan data model yang terperinci dengan slug
        $model = $modelClass::where('slug', $slug)->firstOrFail();

        // Buat data komentar baru
        $comment = $model->comments()->create([
            'user_id' => Auth::id(),
            'article_id' => $model->id,
            'content' => $request['content'],
            'parent_id' => $request->parent_id,
            'reply_target_id' => $request->reply_target_id ?? $request->parent_id,
        ]);

        // Trigger event brodcasting dengan meneruskan data - data yang sudah ada sebelumnya
        CommentPosted::dispatch($comment, $slug);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar berhasil dikirim!'
            ]);
        }
    }

    /**
     * `Function untuk update komentar, belum mengimplementasikan realtime websocket
     *
     * `@param UpdateCommentRequest $request
     * `@param Comment $comment
     * `@return RedirectResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment): RedirectResponse
    {
        // Penggunaan policy agar memastikan orang yang memiliki komentar saja yang bisa melakukan update pada komentar ini
        $this->authorize('update', $comment);

        $comment->update([
            'content' => $request['content']
        ]);

        return back()->with('success', 'Comment updated successfully.')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     *  Function untuk hapus komentar, belum mengimplementasikan realtime websocket
     *
     *  @param Comment $comment
     *  @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // Penggunaan policy agar memastikan orang yang memiliki komentar saja yang bisa melakukan delete pada komentar ini
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
