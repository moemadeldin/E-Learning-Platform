<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;

final class UpdateCommentAction
{
    public function execute(array $data, Comment $comment): Comment
    {
        $comment->update($data);

        return $comment;
    }
}
