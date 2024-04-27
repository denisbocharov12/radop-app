<?php

namespace App\Http\Controllers\v1\Attribute;

use App\Http\Controllers\Controller;
use App\Repositories\Attribute\AttributeRepository;

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
}
