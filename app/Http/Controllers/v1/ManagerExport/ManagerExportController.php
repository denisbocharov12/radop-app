<?php

namespace App\Http\Controllers\v1\ManagerExport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

final class ManagerExportController extends Controller
{
    private const COUNT_OF_PAGINATION = 24;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $disk = Storage::disk('manager_exports');
        $filesList = collect($disk->files());

        $filesWithMetadata = $filesList->map(function ($file) use ($disk) {
            $fileName = basename($file);
            $filePath = $file;

            return [
                'name' => $fileName,
                'path' => $filePath,
                'size' => $disk->size($filePath),
                'modified' => $disk->lastModified($filePath),
            ];
        })->sortByDesc('modified');

        $currentPage = $request->get('page', 1);
        $perPage = self::COUNT_OF_PAGINATION;
        $total = $filesWithMetadata->count();
        $items = $filesWithMetadata->forPage($currentPage, $perPage)->values();

        $files = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('manager-export.index', compact('files'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function download(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
        ]);

        $disk = Storage::disk('manager_exports');
        $fileName = $request->input('file_name');
        $filePath = $fileName;

        if (!$disk->exists($filePath)) {
            $allFiles = $disk->files();
            foreach ($allFiles as $file) {
                if (basename($file) === $fileName) {
                    $filePath = $file;
                    break;
                }
            }
        }

        if (!$disk->exists($filePath)) {
            return redirect()->route('manager-export.index')
                ->with('error', 'Файл не найден');
        }

        $absolutePath = $disk->path($filePath);

        if (!file_exists($absolutePath)) {
            return redirect()->route('manager-export.index')
                ->with('error', 'Файл не найден на диске');
        }

        return response()->download($absolutePath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}

