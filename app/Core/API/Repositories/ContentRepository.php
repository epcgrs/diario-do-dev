<?php

namespace App\Core\API\Repositories;

use App\Core\API\Repositories\Contracts\IContentRepository;
use App\Core\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ContentRepository implements IContentRepository
{
    // tipos de conteúdo ['master', 'feed', 'featured']
    public function paginateMaster(int $perPage): LengthAwarePaginator
    {
        return Content::where('type', 'master')->paginate($perPage);
    }

    public function getFeatured(): Collection
    {
        return Content::where('type', 'featured')->get();
    }

    public function paginateFeed(int $perPage): LengthAwarePaginator
    {
        return Content::where('type', 'feed')->paginate($perPage);
    }

    public function save(array $data): ? Content
    {
        $entity = new Content();

        if( ! empty($data[$entity->getKeyName()]))
        {
            $entityFound = Content::find($data[$entity->getKeyName()]);

            if(!is_null($entityFound))
                $entity = $entityFound;
        }

        return $entity->fill($data)->save() ? $entity : NULL;

    }
}
