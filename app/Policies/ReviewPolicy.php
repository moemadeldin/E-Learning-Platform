<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;

final class ReviewPolicy
{
    public function create(User $user, Course $course): bool
    {
        return $user->enrolledCourses->contains($course) ?? false;
    }

    public function delete(User $user, Review $review): bool
    {
        return $this->hasReview($user, $review);
    }

    private function hasReview(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }
}
