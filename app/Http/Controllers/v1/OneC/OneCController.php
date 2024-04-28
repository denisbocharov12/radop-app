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
use App\Models\ProductCategory;
use App\Models\ProductProfile;
use App\Services\ONEC\ONECManager;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class OneCController extends Controller
{
    private ONECManager $ONECManager;

    public function __construct(
        ONECManager $ONECManager
    )
    {
        $this->ONECManager = $ONECManager;
    }

    public function index()
    {
        return view('onec.index');
    }

    public function importCategories(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        $result = $this->ONECManager->importCategories($json);

        if ($result) {
            toastr()->success('Успешный импорт категорий');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importNomenclature(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        $result = $this->ONECManager->importNomenclature($json);

        if ($result) {
            toastr()->success('Успешный импорт номенклатуры');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('Ошибка при импорте номенклатуры');
        }
    }

    public function importBrands(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        $result = $this->ONECManager->importBrands($json);

        if ($result) {
            toastr()->success('Успешный импорт брэндов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importAttribute(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        $result = $this->ONECManager->importAttributes($json);

        if ($result) {
            toastr()->success('Успешный импорт аттрибутов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importAttributeValues(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        $result = $this->ONECManager->importAttributeValues($json);

        if ($result) {
            toastr()->success('Успешный импорт значений аттрибутов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('Произошла ошибка при импорте значений аттрибутов');
        }
    }

    public function importProductsImages(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)), true);

        $result = $this->ONECManager->importProductsImages($json);

        if ($result) {
            toastr()->success('Синхронизация изображений успешно завершена');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    protected function importPrice()
    {
        $import_price_path = public_path('/1c/price.json');
        $json = json_decode($this->remove_utf8_bom(file_get_contents($import_price_path)), true);
        try {
            if (isset($json['Prices'])) {
                foreach ($json['Prices'] as $product) {
                    if (!empty($product['id'])) {
                        $product_data = Product::where('onec_id', $product['id'])->first();
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
            toastr()->error($errorInfo, 'Error');
            return redirect()->route('admin');
        }

    }

    protected function detalizationProducts()
    {
        $import_nom_path = public_path('/1c/nom.json');
        $json = json_decode($this->remove_utf8_bom(file_get_contents($import_nom_path)), true);
        if (isset($json['Product'])) {
            foreach ($json['Product'] as $product) {
                if (!empty($product['id'])) {
                    foreach ($product['category_id'] as $c) {
                        if (!Category::where('onec_id', $c)->first()->is_parent) {
                            $parentcatid = Category::where('onec_id', $c)->first()->category_id;
                            Product::where('onec_id', $product['id'])->update([
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

    private function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
