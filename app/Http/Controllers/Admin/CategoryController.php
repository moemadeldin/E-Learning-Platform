<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\CreateCategoryAction;
use App\Actions\DeleteCategoryAction;
use App\Actions\UpdateCategoryAction;
use App\DTOs\Admin\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::getCategories()->get();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('dashboard.categories.create');
    }

    public function store(StoreCategoryRequest $request, CreateCategoryAction $action): RedirectResponse
    {
        $action->execute(CategoryDTO::fromArray($request->validated()));

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    public function show(Category $category): View
    {
        return view('dashboard.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('dashboard.categories.update', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category, UpdateCategoryAction $action): RedirectResponse
    {
        $action->execute(CategoryDTO::fromArray($request->validated()), $category);

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    public function destroy(Category $category, DeleteCategoryAction $action): RedirectResponse
    {
        $action->execute($category);

        return redirect()->route('categories.index')->with('success', 'Category Deleted successfully!');
    }
}
