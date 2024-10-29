<?php

namespace App\Http\Controllers\v1\Category;

use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Attachments\AttachmentNotFoundValidationException;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryNotFoundValidationException;
use App\Exceptions\Category\CategoryUniqueNameException;
use App\Exceptions\Category\CategoryUniqueNameValidationException;
use App\Exceptions\NotAjaxRequestException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\CategoryDataMapper;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Models\Category;
use App\Services\Category\CategoryManager;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $categories = $this->categoryRepository->getAllPaginatedWithFilters();

        return view('category.index', compact([
            'categories',
            'query'
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

    public function deleteMedia(ModelMediaDeleteRequest $request, Category $category)
    {
        try {
            $this->categoryManager->deleteMediaFromCategory($request, $category);

            return response()->json(['status' => true]);
        } catch (AttachmentNotFoundException $e) {
            throw new AttachmentNotFoundValidationException();
        }
    }

    public function sortIndex()
    {
        $categories = $this->categoryRepository->getAllSortedByOrder();

        return view('category.sorts', compact([
            'categories',
        ]));
    }

    public function sortOrder(Request $request)
    {
        $categories = $this->categoryRepository->getAllSortedByOrder();

        foreach ($categories as $category) {
            foreach ($request->order as $order) {
                if ($order['id'] == $category->id) {
                    $category->update(['order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Категории успешно отсортированы']);
    }
}
