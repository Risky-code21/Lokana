<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $likesCount;
    public $viewsCount;
    public $article_id;

    /**
     * Create a new event instance.
     */
    public function __construct(Article $article)
    {
        $this->article_id = $article->id;
        $this->likesCount = $article->likes()->count();
        $this->viewsCount = $article->views()->count();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('articles.', $this->article_id),
        ];
    }
}
