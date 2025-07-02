<?php

namespace App\Enums;

final class OrderHistoryTypes
{
    public function getDownloadedExcelType(): string
    {
        return 'downloaded_excel';
    }

    public function getEditedType(): string
    {
        return 'edited';
    }

    public function getUpdatedStatusType(): string
    {
        return 'updated_status';
    }

    public function getAll(): array
    {
        return [
            'downloaded_excel' => 'downloaded_excel',
            'edited' => 'edited',
            'updated_status' => 'updated_status',
        ];
    }
} 