<?php

namespace Database\Seeders\Product;

use App\Models\Category;
use App\Services\ONEC\ONECManager;
use Illuminate\Database\Seeder;

class CategorySeeder extends seeder
{

    private $ONECManager;

    public function __construct()
    {
        $this->ONECManager = new ONECManager();
    }
    public function run() :void
    {

        Category::truncate();


        $categories = [
            [
                'name' => 'Category 1',
                'summary' => 'Description for Category 1',
                'status' => false,
            ],
            [
                'name' => 'Category 2',
                'summary' => 'Description for Category 2',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            $category = Category::create([
                'name' => $category['name'],
                'summary' => $category['summary'],
                'status' => $category['status'],
            ]);

            $categoryOneCId = $this->ONECManager->getOneCIdForCreate($category);

            $category->update([
                'onec_id' => $categoryOneCId
            ]);
        }
    }
}
