<?php

namespace App\Http\Controllers\v1\Attribute;

use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;
use Illuminate\Http\Request;

final class AttributeController extends Controller
{
    private AttributeRepository $attributeRepository;

    public function __construct(
        AttributeRepository $attributeRepository,
    )
    {
        $this->attributeRepository = $attributeRepository;
    }
    public function index()
    {
        $attributes = $this->attributeRepository->getAllPaginatedWithFilters();

        return view('attribute.index', compact([
            'attributes',
        ]));
    }

    public function sort()
    {
        $attributes = $this->attributeRepository->getAllSorted();

        return view('attribute.sort', compact([
            'attributes',
        ]));
    }

    public function sortOrder(Request $request)
    {
        $attributes = $this->attributeRepository->getAllSorted();

        foreach ($attributes as $attribute) {
            foreach ($request->order as $order) {
                if ($order['id'] == $attribute->id) {
                    $attribute->update(['order' => $order['position']]);
                }
            }
        }

        return response()->json(['status' => true, 'text' => 'Атрибуты успешно отсортированы']);
    }
}
