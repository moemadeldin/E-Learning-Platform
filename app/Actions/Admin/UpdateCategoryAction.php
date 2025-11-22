<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\Admin\CategoryDTO;
use App\Models\Category;

final class UpdateCategoryAction
{
    public function execute(CategoryDTO $dto, Category $category): Category
    {
        $category->update($dto->toArray());

        return $category;
    }
}
