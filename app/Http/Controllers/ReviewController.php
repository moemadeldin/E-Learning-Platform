<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Reviews\CreateReviewAction;
use App\Actions\Reviews\DeleteReviewAction;
use App\Actions\Reviews\UpdateReviewAction;
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
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Review $review)
    {

        return view('pages.edit-review', [
            'course' => $course,
            'review' => $review,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReviewRequest $request, Review $review, UpdateReviewAction $action): RedirectResponse
    {
        $this->authorize('update', $review);

        $action->execute($request->validated(), $review);

        return redirect()->back()->with('success', 'Review updated successfully');
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
