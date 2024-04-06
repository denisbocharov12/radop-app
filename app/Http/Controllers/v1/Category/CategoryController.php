<?php

namespace App\Http\Controllers\v1\Category;

use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Exceptions\Category\CategoryUniqueNameException;
use App\Exceptions\Category\CategoryUniqueNameValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\CategoryDataMapper;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryManager;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;
    private CategoryManager $categoryManager;
    private CategoryDataMapper $categoryDataMapper;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryManager    $categoryManager,
        CategoryDataMapper $categoryDataMapper
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryManager = $categoryManager;
        $this->categoryDataMapper = $categoryDataMapper;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllPaginatedWithFilters();

        return view('category.index', compact([
            'categories',
        ]));
    }

    public function store(CategoryRequest $request)
    {
        $categoryData = $this->categoryDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->categoryManager->store($categoryData, $request);

            return redirect()->route('category.index');
        } catch (CategoryUniqueNameException $e) {
            throw new CategoryUniqueNameValidationException();
        }
    }

    public function edit(Category $category)
    {
        $categories = $this->categoryRepository->getAllIgnored($category);

        return view('category.edit', compact([
            'category', 'categories'
        ]));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $categoryData = $this->categoryDataMapper->mapFromRequestToNormalized($request);

        try {
            $this->categoryManager->update($categoryData, $category, $request);

            return redirect()->route('category.index');
        } catch (CategoryUniqueNameException) {
            throw new CategoryUniqueNameValidationException();
        }
    }

    public function destroy(CategoryDeleteRequest $request)
    {
        if (!$request->ajax()) {
            throw new NotAjaxRequestException();
        }

        try {
            $this->categoryManager->delete($request);

            return response()->json(['id' => $request->category_id]);
        } catch (CategoryNotFoundException $e) {
            throw new CategoryNotFoundValidationException();
        }
    }
}
