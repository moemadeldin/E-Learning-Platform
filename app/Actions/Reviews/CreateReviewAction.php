<?php

declare(strict_types=1);

namespace App\Actions\Reviews;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;

final class CreateReviewAction
{
    public function execute(User $user, array $data, Course $course): Review
    {
        return $user->reviews()->create([
            'course_id' => $course->id,
            'review' => $data['review'],
            'rating' => $data['rating'],
        ]);
    }
}
