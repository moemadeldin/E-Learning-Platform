<?php

declare(strict_types=1);

namespace App\Actions\Reviews;

use App\Models\Review;

final class UpdateReviewAction
{
    public function execute(array $data, Review $review): Review
    {
        $review->update($data);

        return $review;
    }
}
