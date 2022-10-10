<?php

namespace App\Services\Documents;

use App\Exceptions\UsedInOtherTableException;
use Illuminate\Support\Collection;
use App\Models\DocumentTemplate;
use Throwable;

class DocumentTemplateService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return DocumentTemplate::orderBy('id')->get();
    }

    /**
     * @param  array  $data
     * @return DocumentTemplate
     */
    public function store(array $data): DocumentTemplate
    {
        return DocumentTemplate::create($data);
    }

    /**
     * @param  int  $documentTemplateId
     * @return DocumentTemplate
     */
    public function getDocumentTemplateById(int $documentTemplateId): DocumentTemplate
    {
        return DocumentTemplate::findOrFail($documentTemplateId);
    }

    /**
     * @param  int  $documentTemplateId
     * @param  array  $data
     * @return DocumentTemplate
     */
    public function update(int $documentTemplateId, array $data): DocumentTemplate
    {
        $documentTemplate = $this->getDocumentTemplateById($documentTemplateId);
        $documentTemplate->update($data);

        return $documentTemplate;
    }

    /**
     * @param  int  $documentTemplateId
     * @throws UsedInOtherTableException
     */
    public function delete(int $documentTemplateId): void
    {
        try {
            DocumentTemplate::where('id', $documentTemplateId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Шаблон документа нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
