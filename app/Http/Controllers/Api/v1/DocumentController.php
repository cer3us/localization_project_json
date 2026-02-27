<?php

namespace App\Http\Controllers\Api\v1;

use App\Facades\Document as DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\AddDocumentRequest;
use App\Http\Requests\Document\GetDocumentRequest;
use App\Http\Requests\Document\GetDocumentsRequest;
use App\Http\Requests\Document\ImportTranslationsRequest;
use App\Http\Resources\Document\MinifiedDocumentResource;
use App\Models\Document;

class DocumentController extends Controller
{
    public function add(AddDocumentRequest $request)
    {
        $data = $request->validated();
        DocumentService::setProject($data['projectId'])
            ->add($data['documents']);

        return responseCreated($data);
    }

    public function list(GetDocumentsRequest $request)
    {
        $data = $request->validated();
        return MinifiedDocumentResource::collection(
            DocumentService::setProject($data['projectId'])
                ->list()
        );
    }

    public function import(Document $document, ImportTranslationsRequest $request)
    {
        $data = $request->validated();
        return responseOk(DocumentService::setDocument($document)
            ->importTranslations($data['lang'], $data['data']));
    }

    public function show(Document $document, GetDocumentRequest $request)
    {
        $data = $request->validated();

        return DocumentService::setDocument($document)
            ->getTranslations($data['lang']);
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return responseOk($document);
    }
}
