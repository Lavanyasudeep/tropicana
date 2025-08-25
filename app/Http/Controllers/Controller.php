<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\AttachmentController;

use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   public function handleAttachments($model, Request $request)
    {
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');

            // Get dynamic primary key field and its value
            $primaryKeyName = $model->getKeyName();
            $primaryKeyValue = $model->getKey();

            // Prepare new Request with files and metadata
            $attachmentRequest = new Request();
            $attachmentRequest->files->set('attachments', $files);
            $attachmentRequest->merge([
                'table_name' => $model->getTable(),
                // 'primary_key_name' => $primaryKeyName,
                'row_id' => $primaryKeyName,
            ]);
            $attachmentRequest->setMethod('POST');

            // Call the attachment controller
            app(AttachmentController::class)->store($attachmentRequest);
        }
    }

    public function buildMenuTree($menus, $parentId = null)
    {
        $tree = [];

        foreach ($menus->where('parent_id', $parentId) as $menu) {
            $children = $this->buildMenuTree($menus, $menu->menu_id);
            $tree[] = [
                'menu_id' => $menu->menu_id,
                'menu_name' => $menu->menu_name,
                'children' => $children,
            ];
        }

        return $tree;
    }

}
