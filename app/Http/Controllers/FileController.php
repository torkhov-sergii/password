<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\File;

class FileController extends Controller {

    //post - ajax/file/{id}/destroy
    public function destroy(File $fileModel, $id) {
        $fileModel->destroy_file($id);
    }
}
