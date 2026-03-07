<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Pakai ini agar instan
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Penggunaan interface shouldbroadcast now
class CommentPosted implements ShouldBroadcastNow
{

    //  Penggunaan traits
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // properti yang diinsialisasi nantinya dengan constructor function
    public $html;
    public $slug;

    // Constructor function
    public function __construct(Comment $comment, $slug)
    {
        // Insialisasi properti slug
        $this->slug = $slug;

        // Insialisasi properti html, agar bersi comment bubble component
        // Ini sebenearny agar riskan karena bisa membuat response reverb menjadi berat, karena pada saat pembuatan ini kita harus menaikan kapisitas payload dari server reverb kita menjadi 10kb
        $this->html = view('components.comment-bubble', [
            'comment' => $comment,
            'modelSlug' => $slug
        ])->render();
    }

    /**
     *  Function untuk mengelola pembuatan event
     *
     *  @return array
     */
    public function broadcastOn(): array
    {
        // Membuat channle baru untuk bisa transfer isi properti dan laravel echo bisa menerima data properti tadi melalui channel ini
        return [
            new Channel('article.' . $this->slug),
        ];
    }
}
