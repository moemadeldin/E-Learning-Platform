<?php

declare(strict_types=1);

namespace App\Actions\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

final class CreateCommentAction
{
    public function execute(array $data, Model $model): Comment
    {
        return $model->comments()->create([
            'user_id' => auth()->id(),
            'parent_comment_id' => $data['parent_comment_id'] ?? null,
            'comment' => $data['comment'],
        ]);
    }
}
