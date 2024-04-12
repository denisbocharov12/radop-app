<?php

namespace Database\Seeders\Product;

use App\Models\Brand;
use App\Services\ONEC\ONECManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends seeder
{
    private $ONECManager;

    public function __construct()
    {
        $this->ONECManager = new ONECManager();
    }

    public function run(): void
    {

        DB::table('brands')->truncate();

        $brands = [
            [
                'title' => 'Brand 1',
                'description' => 'This is the description for Brand 1',
                'status' => true,
            ],
            [
                'title' => 'Brand 2',
                'description' => 'This is the description for Brand 2',
                'status' => false,
            ],

        ];


        foreach ($brands as $brand) {
            $brand = Brand::create([
                'title' => $brand['title'],
                'description' => $brand['description'],
                'status' => $brand['status'],
                'slug' => Str::slug($brand['title']) . '-' . Str::random(5),
            ]);

            $brandOneCId = $this->ONECManager->getOneCIdForCreate($brand);

            $brand->update([
                'onec_id' => $brandOneCId
            ]);
        }

    }
}
