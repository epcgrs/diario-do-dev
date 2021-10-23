<?php

namespace App\Core\API\Services;

use App\Core\API\Repositories\Contracts\IContentRepository;
use App\Core\API\Services\Contracts\IContentService;
use App\Core\Models\Content;
use App\Events\NewMasterContentAvaliable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ContentService implements IContentService
{
    /* @var IContentRepository */
    protected $contentRepository;

    public function __construct(IContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function paginateMaster(int $perPage): LengthAwarePaginator
    {
        return $this->contentRepository->paginateMaster($perPage);
    }

    public function getFeatured(): Collection
    {
        return $this->contentRepository->getFeatured();
    }

    public function paginateFeed(int $perPage): LengthAwarePaginator
    {
        return $this->contentRepository->paginateFeed($perPage);
    }

    public function save(array $data): ?Content
    {
        if ($newContent = $this->contentRepository->save($data)) {
            if ($newContent->type == 'master') {
                event(new NewMasterContentAvaliable('Há um novo conteúdo na Home!'));
            }
            return $newContent;
        }

        return NULL;
    }

}
