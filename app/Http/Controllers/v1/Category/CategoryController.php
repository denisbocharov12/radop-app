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

    public function sortCatalogIndex()
    {
        $categories = $this->categoryRepository->getAllParentsSortedByCatalogOrder();

        return view('category.catalog_sorts', compact([
            'categories',
        ]));
    }

    public function sortCatalogOrder(Request $request)
    {
        $categories = $this->categoryRepository->getAllParentsSortedByCatalogOrder();

        foreach ($categories as $category) {
            foreach ($request->order as $order) {
                if ($order['id'] == $category->id) {
                    $category->update(['catalog_order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Категории каталога успешно отсортированы']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function sortProducts(Request $request)
    {
        $categoryId = $request->query('category_id');
        
        if (!$categoryId) {
            return redirect()->route('category.select.category')
                ->with('error', 'Не выбрана категория');
        }

        $category = $this->categoryRepository->getByOnecId($categoryId);
        
        if (!$category) {
            return redirect()->route('category.select.category')
                ->with('error', 'Категория не найдена');
        }

        $products = $this->categoryRepository->getAllProductsByCategoryWithSort($category);

        return view('category.sort-products', compact([
            'category',
            'products'
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortProductsOrder(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json(['status' => false, 'text' => 'Не выбрана категория'], 400);
        }

        $category = $this->categoryRepository->getByOnecId($categoryId);
        
        if (!$category) {
            return response()->json(['status' => false, 'text' => 'Категория не найдена'], 404);
        }

        $products = $this->categoryRepository->getAllProductsByCategoryWithSort($category);

        foreach ($products as $product) {
            foreach ($request->order as $order) {
                if ($order['id'] == $product->onec_id) {
                    $this->categoryManager->updateProductSortInCategory($category->onec_id, $product->onec_id, $order['position']);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Товары в категории успешно отсортированы']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function selectCategoryForSort(Request $request)
    {
        $categories = $this->categoryRepository->getAll();
        $selectedCategory = null;

        if ($request->has('category_id') && $request->category_id) {
            $selectedCategory = $this->categoryRepository->getByOnecId($request->category_id);
            if ($selectedCategory) {
                $selectedCategory->load('products');
            }
        }

        return view('category.select-category', compact([
            'categories',
            'selectedCategory'
        ]));
    }
}
