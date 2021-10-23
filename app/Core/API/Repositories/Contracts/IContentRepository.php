<?php

namespace App\Core\API\Repositories\Contracts;

use App\Core\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IContentRepository
{
    public function paginateMaster(int $perPage): LengthAwarePaginator;
    public function getFeatured(): Collection;
    public function paginateFeed(int $perPage): LengthAwarePaginator;
    public function save(array $data): ? Content;
}
