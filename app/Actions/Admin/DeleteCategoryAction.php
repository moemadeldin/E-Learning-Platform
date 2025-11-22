<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Category;

final class DeleteCategoryAction
{
    public function execute(Category $category): void
    {
        $category->delete();
    }
}
