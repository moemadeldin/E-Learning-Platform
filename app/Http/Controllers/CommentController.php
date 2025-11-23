<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Comments\CreateCommentAction;
use App\Actions\Comments\DeleteCommentAction;
use App\Actions\Comments\UpdateCommentAction;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;

final class CommentController extends Controller
{
    public function storeCourseComment(StoreCommentRequest $request, Course $course, CreateCommentAction $action): RedirectResponse
    {
        $action->execute($request->validated(), $course);

        return back()->with('success', 'Comment added successfully');
    }

    public function storeLessonComment(StoreCommentRequest $request, Lesson $lesson, CreateCommentAction $action): RedirectResponse
    {
        $action->execute($request->validated(), $lesson);

        return back()->with('success', 'Comment added successfully');
    }

    public function update(UpdateCommentRequest $request, UpdateCommentAction $action, Comment $comment): RedirectResponse
    {
        $action->execute($request->validated(), $comment);

        return back()->with('success', 'updated added successfully');
    }

    public function destroy(DeleteCommentAction $action, Comment $comment): RedirectResponse
    {
        $action->execute($comment);

        return back()->with('success', 'Comment deleted successfully');
    }
}
