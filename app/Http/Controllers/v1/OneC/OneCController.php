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
use App\Repositories\Onec\OnecRepository;
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
        ONECManager $ONECManager,
        private readonly OnecRepository $onecRepository,
    )
    {
        $this->ONECManager = $ONECManager;
    }

    public function index()
    {
        $productBatch = $this->onecRepository->getProductImportBatches();
        $categoryBatch = $this->onecRepository->getCategoryImportBatches();
        $brandBatch = $this->onecRepository->getBrandImportBatches();
        $attributeBatch = $this->onecRepository->getAttributeImportBatches();
        $attributeValueBatch = $this->onecRepository->getAttributeValueImportBatches();
        $descriptionBatch = $this->onecRepository->getDescriptionImportBatches();
        $packageBatch = $this->onecRepository->getPackageImportBatches();

        return view('onec.index', compact([
            'productBatch',
            'categoryBatch',
            'brandBatch',
            'attributeBatch',
            'attributeValueBatch',
            'descriptionBatch',
            'packageBatch'
        ]));
    }

    public function importCategories(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

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
        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

        $result = $this->ONECManager->importNomenclature($json);

        if ($result) {
            toastr()->success('Импорт номенклатуры добавлен в очередь.');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('Ошибка при импорте номенклатуры');
        }
    }

    public function importPackages(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

        $result = $this->ONECManager->importPackages($json);

        if ($result) {
            toastr()->success('Импорт упаковки добавлен в очередь.');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('Ошибка при импорте упаковки');
        }
    }

    public function importBrands(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

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

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

        $result = $this->ONECManager->importAttributes($json);

        if ($result) {
            toastr()->success('Успешный импорт аттрибутов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }
    }

    public function importAttributeValues(Request $request)
    {
        $importFile = $request->file('attachment');

        if ($importFile === null)
        {
            return redirect()->route('import-export-data.index');
        }

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

        $result = $this->ONECManager->importAttributeValues($json);

        if ($result) {
            toastr()->success('Успешный импорт значений аттрибутов');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('Произошла ошибка при импорте значений аттрибутов');
        }
    }

    public function importDescriptions(Request $request)
    {
        $importFile = $request->file('attachment');

        if ($importFile === null)
        {
            return redirect()->route('import-export-data.index');
        }

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));

        $result = $this->ONECManager->importProductDescriptions($json);

        if ($result) {
            toastr()->success('Успешный импорт описания');
            return redirect()->route('import-export-data.index');
        } else {
            return redirect()->back()->withErrors('Произошла ошибка при импорте значений аттрибутов');
        }
    }

    public function importImages()
    {
        return redirect()->route('import-export-data.index');
    }

    private function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
