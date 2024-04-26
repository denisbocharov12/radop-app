<?php

namespace App\Http\Controllers\v1\OneC;

use App\Http\Controllers\Controller;
use App\Http\Requests\OneC\OneCRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class OneCController extends Controller
{
    public function index(){
        return view('onec.index');
    }

    public function importCategories(OneCRequest $request){

        $importFile = $request->file('attachment');

        if (!$importFile->isValid()){
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        if(isset($json['Categories'])){
            foreach ($json['Categories'] as $category){
                if(!empty($category['id'])) {
                    if(!empty($category['parent_id'])){
                        $is_parent = false;
                        $category_id = $category['parent_id'];
                    } else{
                        $is_parent = true;
                        $category_id = null;
                    }
                    $data = array(
                        'name' => $category['name_ro'],
                        'slug' => $category['id'],
                        'is_parent' => $is_parent,
                        'parent_id' => $category_id
                    );
                    Category::updateOrCreate([
                        'onec_id'=>$category['id']
                    ], $data);
                }
            }
            toastr()->success('Успешный импорт категорий');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importNomenclature(OneCRequest $request){
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()){
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        if(isset($json['Product'])){
            DB::table('product_categories')->truncate();

            foreach ($json['Product'] as $product){
                if(!empty($product['id'])) {
                    $status = $product['status'] ? true : false;

                    $data = array(
//                        'title_full' => $product['name_ru'],
                        'title' => $product['name_ru'],
                        'slug' => Str::slug($product['name_ru']) . '-' . $product['id'],
//                        'cat_id' => json_encode($product['category_id'], true),
                        'price' => $product['price'],
                        'status' => $status,
                        'stock' => $product['stock'],
                        'brand_id' => $product['brand_id']
                    );

                    $product_model = Product::updateOrCreate([
                        'onec_id' => $product['id']
                    ], $data);

                    foreach ($product['category_id'] as $item){
                        $existedCategory = Category::query()->where('onec_id', $item)->first();

                        if ($existedCategory !== null)
                        {
                            $currentCategory = Category::query()->where('onec_id', $item)->first();

                            $parentsCollection = collect();

                            $parentCategoryFromCurrent = $currentCategory->parent;

                            while (!empty($parentCategoryFromCurrent)) {
                                $parentsCollection->push($parentCategoryFromCurrent);
                                $parentCategoryFromCurrent = $parentCategoryFromCurrent->parent;
                            }

                            dd($parentsCollection);

                            foreach ($parentCats as $parentCategory){
                                DB::table('product_categories')->insert([
                                    'category_id'=>$parentCategory->id,
                                    'product_id'=>$product_model->id
                                ]);
                            }
                        }

                    }
                }
            }
            toastr()->success('Успешный импорт категорий');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importBrands(OneCRequest $request){

        $importFile = $request->file('attachment');

        if (!$importFile->isValid()){
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        if(isset($json['Brands'])){
            foreach ($json['Brands'] as $brand){
                if(!empty($brand['id'])) {
                    $data = array(
                        'title' => $brand['name_ro'],
                        'slug' => Str::slug($brand['name_ro']). '-' . $brand['id'],
                        'onec_id' => $brand['id']
                    );
                    Brand::updateOrCreate([
                        'onec_id'=> $brand['id'],
                    ], $data);
                }
            }
            toastr()->success('Успешный импорт брэндов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importAttribute(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()){
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        if(isset($json['Characteristics'])){
            foreach ($json['Characteristics'] as $attribute){
                if(!empty($attribute['id'])) {
                    $data = array(
                        'name' => $attribute['name_ro'],
                        'slug' => Str::slug($attribute['name_ro']),
                        'onec_id' => $attribute['id']
                    );
                    Attribute::updateOrCreate([
                        'onec_id'=>$attribute['id']
                    ], $data);
                }
            }
            toastr()->success('Успешный импорт аттрибутов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importAttributeValues(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()){
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        if(isset($json['ProductCharacteristics'])){
            DB::beginTransaction();

            try {
                AttributeValue::query()->truncate();
                ProductAttribute::query()->truncate();

                foreach ($json['ProductCharacteristics'] as $attributeValue){
                    if(!empty($attributeValue['product_id'])) {

                        $productId = Product::query()
                            ->where('onec_id', $attributeValue['product_id'])
                            ->first()->id;

                        AttributeValue::query()->create([
                            'attribute_onec_id' => $attributeValue['characteristic_id'],
                            'product_onec_id' => $attributeValue['product_id'],
                            'value' => $attributeValue['name_ro']
                        ]);

                        $attributeId = Attribute::query()
                            ->where('onec_id', $attributeValue['characteristic_id'])
                            ->first()->id;

                        ProductAttribute::query()->create([
                            'product_id' => $productId,
                            'attribute_id' => $attributeId
                        ]);
                    }
                }
                toastr()->success('Успешный импорт значений аттрибутов');
                return redirect()->route('import-export-data.index');
            } catch (\Exception $e){
                DB::rollBack();
                return redirect()->back()->withErrors('Произошла ошибка при импорте значений аттрибутов');
            }
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importProductsImages(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()){
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        if(isset($json['Photos'])){

            ProductImage::query()->truncate();

            foreach ($json['Photos'] as $photo){
                ProductImage::create([
                    'image_path' => '/images/'.$photo['filename'],
                    'product_id' => $photo['id'],
                    'title' => 'product-'.Str::slug($photo['id'])
                ]);

            }
            toastr()->success('Синхронизация изображений успещно завершена');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    protected function importPrice(){
        $import_price_path = public_path('/1c/price.json');
        $json = json_decode($this->remove_utf8_bom(file_get_contents($import_price_path)), true);
        try {
            if(isset($json['Prices'])){
                foreach ($json['Prices'] as $product){
                    if(!empty($product['id'])) {
                        $product_data = Product::where('onec_id',$product['id'])->first();
                        $product_data->price = $product['price'];
                        $product_data->stock = $product['qwty'];
                        $product_data->save();
                    }
                }
            } else {
                return false;
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            toastr()->error($errorInfo,'Error');
            return redirect()->route('admin');
        }

    }

    protected function detalizationProducts(){
        $import_nom_path = public_path('/1c/nom.json');
        $json = json_decode($this->remove_utf8_bom(file_get_contents($import_nom_path)), true);
        if(isset($json['Product'])){
            foreach ($json['Product'] as $product){
                if(!empty($product['id'])) {
                    foreach ($product['category_id'] as $c){
                        if(!Category::where('onec_id',$c)->first()->is_parent){
                            $parentcatid = Category::where('onec_id',$c)->first()->category_id;
                            Product::where('onec_id',$product['id'])->update([
                                'cat_id' => $parentcatid,
                                'child_cat_id' => $c
                            ]);
                        }
                    }
                }
            }
        } else {
            return false;
            //return redirect()->route('import-export-data')->with('error','Что-то пошло не так...');
        }

    }

    private function remove_utf8_bom($text){
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
