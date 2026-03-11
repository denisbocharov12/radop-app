<?php

namespace App\Http\Controllers\v1\OneC;

use App\Http\Controllers\Controller;
use App\Http\Requests\OneC\OneCRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductProfile;
use App\Jobs\ImportProductImagesJob;
use App\Jobs\OptimizeBrandImagesJob;
use App\Repositories\Onec\OnecRepository;
use App\Services\ONEC\ImportFailureAnalyzer;
use App\Services\ONEC\ONECManager;
use Illuminate\Http\Request;

class OneCController extends Controller
{
    public function __construct(
        private readonly ONECManager $ONECManager,
        private readonly OnecRepository $onecRepository,
        private readonly ImportFailureAnalyzer $importFailureAnalyzer,
    ) {
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

        $productImportFailedAnalyses = collect();
        if ($productBatch !== null) {
            $failedJobs = $this->onecRepository->getProductImportFailedJobs($productBatch->id);
            $productImportFailedAnalyses = $failedJobs->map(fn ($job) => $this->importFailureAnalyzer->analyze($job));
        }

        return view('onec.index', compact([
            'productBatch',
            'categoryBatch',
            'brandBatch',
            'attributeBatch',
            'attributeValueBatch',
            'descriptionBatch',
            'packageBatch',
            'productImportFailedAnalyses',
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

    public function importAndSyncCategoriesFromNomenclatureOptional(OneCRequest $request)
    {
        $importFile = $request->file('attachment');

        if (!$importFile->isValid()) {
            return redirect()->back()->withErrors('This file is invalid for structure');
        }

        $json = json_decode($this->remove_utf8_bom(file_get_contents($importFile)));
        $result = $this->ONECManager->importAndSyncCategoriesFromNomenclatureOptional($json);

        if ($result) {
            toastr()->success('Синхронизация категорий из номенклатуры добавлена в очередь.');
            return redirect()->route('import-export-data.index');
        }

        return redirect()->back()->withErrors('Ошибка при синхронизации категорий');
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
            toastr()->success('Успешный импорт брендов');
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
        $products = Product::where('status', true)
            ->pluck('id')
            ->chunk(40);

        $jobCount = 0;

        foreach ($products as $productIds) {
            ImportProductImagesJob::dispatch($productIds->toArray(), true);
            $jobCount++;
        }

        toastr()->success("Добавлено {$jobCount} задач в очередь для импорта изображений");
        return redirect()->route('import-export-data.index');
    }

    public function optimizeBrandImages()
    {
        $brands = Brand::where('status', true)
            ->whereHas('media', function ($q) {
                $q->where('collection_name', 'media');
            })
            ->pluck('id')
            ->chunk(40);

        $jobCount = 0;

        foreach ($brands as $brandIds) {
            OptimizeBrandImagesJob::dispatch($brandIds->toArray(), true);
            $jobCount++;
        }

        toastr()->success("Добавлено {$jobCount} задач в очередь для оптимизации изображений брендов");
        return redirect()->route('import-export-data.index');
    }

    public function resetProductDescriptions(Request $request)
    {
        $updatedCount = ProductProfile::query()->get()->each(function ($product) {
            $product->update(['summary' => [
                'ru' => '',
                'ro' => '',
            ]]);
        })->count();

        toastr()->success("Сброшено описаний для {$updatedCount} товаров");
        return redirect()->route('import-export-data.index');
    }

    private function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
