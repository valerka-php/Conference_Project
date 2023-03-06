<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\DeleteRequest;
use App\Http\Requests\Category\EditRequest;
use App\Http\Requests\Category\ShowRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //
    }

    public function create(CreateRequest $request)
    {
        return inertia('Category/Create', [
            'parentCategories' => Category::all(),
        ]);
    }

    public function store(StoreRequest $request, Category $category)
    {
        $category->create($request->validated());

        return redirect()->route('categories.create')->with('message', __('category.created', ['title' => $request->title]));
    }

    public function show(ShowRequest $request)
    {
        return inertia('Category/ShowCategories', [
            'categoriesTree' => Category::createTree(),
        ]);
    }

    public function edit(EditRequest $request, Category $category)
    {
        return inertia('Category/Edit', [
            'category' => $category,
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.show')->with('message', __('category.updated', ['title' => $category->title]));
    }

    public function delete(DeleteRequest $request, Category $category)
    {
        $category->delete();

        return back()->with('message', __('category.deleted', ['title' => $category->title]));
    }
}
