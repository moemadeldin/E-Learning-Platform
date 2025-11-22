<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\Admin\CategoryDTO;
use App\Models\Category;

final class CreateCategoryAction
{
    public function execute(CategoryDTO $dto): Category
    {
        $category = Category::create($dto->toArray());

        return $category;
    }
}
