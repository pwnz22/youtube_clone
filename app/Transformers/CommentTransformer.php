<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'channel',
        'replies'
    ];

    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'body' => $comment->body,
            'created_at' => $comment->created_at->toDateTimeString(),
            'created_at_human' => $comment->created_at->diffForHumans()
        ];
    }

    public function includeChannel(Comment $comment)
    {
        return $this->item($comment->user->channel->first(), new ChannelTransformer);
    }

    public function includeReplies(Comment $comment)
    {
        return $this->collection($comment->replies, new CommentTransformer);
    }
}