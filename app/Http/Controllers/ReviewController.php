<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Reviews\CreateReviewAction;
use App\Actions\Reviews\DeleteReviewAction;
use App\Enums\Pagination;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.my-reviews', [
            'reviews' => Review::paginate(Pagination::REVIEWS_PER_PAGE->value),
            'reviews_count' => Review::count(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(#[CurrentUser()] User $user, StoreReviewRequest $request, Course $course, CreateReviewAction $action): RedirectResponse
    {
        $this->authorize('create', [Review::class, $course]);

        $action->execute($user, $request->validated(), $course);

        return redirect()->route('courses.show', $course)->with('success', 'Review created successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review, DeleteReviewAction $action): RedirectResponse
    {
        $this->authorize('delete', $review);

        $action->execute($review);

        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}
