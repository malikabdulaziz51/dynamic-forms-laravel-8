<?php

namespace App\Http\Controllers\admin\Form;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Northwestern\SysDev\DynamicForms\Storage\Concerns\HandlesDynamicFormsStorage;


/**
 * Storage/retrieval for file uploads.
 */
class DynamicFormsStorageController extends Controller
{
    use HandlesDynamicFormsStorage;

    /**
     * Performs an authorization check for upload/download requests.
     *
     * This method should throw an AuthorizationException if the user is not authorized to
     * perform the requested $action on $fileKey.
     *
     * The easiest way to do that is to write an authorization gate, and then run Gate::authorize('fileUpload').
     * This method will throw an AuthorizationException if the user fails the check.
     *
     * However, you are free to implement this method in whatever way makes sense to you. You do not need to use
     * the Gate facade.
     *
     * @param string $action upload or download
     * @param string $fileKey The file key (S3 object key or file name)
     * @param Request $request The full Request object
     *
     * @throws AuthorizationException
     */
    protected function authorizeFileAction(string $action, string $fileKey, Request $request, string $backend): void
    {
        /*
        $permission = "${action}Files"; // uploadFiles, downloadFiles -- it's a convention

        Gate::authorize($permission, [
            $request->user(),
            $fileKey
        ]);
        */

        throw new AuthorizationException('Please implement the authorize method in ' . __CLASS__, '403');
    }
}
