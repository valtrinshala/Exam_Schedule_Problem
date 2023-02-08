<?php

namespace App\Services;

class FileContentData
{
    public function __construct()
    {
    }

    public function get(): array
    {
        return cache('file_data') ?? [];
    }

    public function set(array $data): void
    {
        cache()->put('file_data', $data);
    }

    public function forget(): void
    {
        cache()->forget('file_data');
    }
}