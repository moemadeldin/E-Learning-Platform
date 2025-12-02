<?php

declare(strict_types=1);

namespace App\Actions\Reviews;

use App\Models\Review;

final class DeleteReviewAction
{
    public function execute(Review $review): void
    {
        $review->forceDelete();
    }
}
