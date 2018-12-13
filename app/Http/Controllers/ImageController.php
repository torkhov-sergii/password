<?php

namespace App\Http\Controllers;

use App\Models\Main;
use App\Models\Product;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Input;
use Auth;

class ImageController extends Controller {

    //сохранить фотку
    public function postAjaxImageSave(Request $request, Image $imageModel) {
        $object_type = $request->input('object_type');
        $object_id = $request->input('object_id');
        $image_type = $request->input('image_type');

        //в зависимости от $object_type выбираем модель к какой прикрепить фотку
        if($object_type == 'user') {
            //$object = Auth::user();
            $object = User::findOrFail($object_id);
        }

        if($object_type == 'main') {
            $mainModel = new Main;
            $object = $mainModel->getNodeById($object_id);
        }

        if($request->file('preview')) {
            $newpreview = $object->addImage($request->file('preview'), 1, $image_type);
            return $newpreview->getCache(['original'=>true]);
        }

        if($request->file('images')) {
            $object->addImage($request->file('images'), 0);
        }
    }

    //кропнуть фотку
    public function postAjaxImageCrop(Request $request) {
        $crop_coords = $request->input('crop_coords');

        $img_url = $request->input('img_url');

        $img = \Image::make(public_path($img_url));
        $img->crop(ceil($crop_coords['w']), ceil($crop_coords['h']), ceil($crop_coords['x']), ceil($crop_coords['y']));
        $img->save();
    }

    //post - ajax/image/{id}/destroy
    public function destroy(Image $imageModel, $id) {
        $imageModel->destroyImageById($id);
    }

    //upload фотки из редактора Trumbowyg
    public function UploadTrumbowyg(Request $request, $id) {
        $destinationPath = public_path().'/upload/images/editor/'.$id.'/';
        $image = $request->file('file');

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $pathInfo = pathinfo($image->getClientOriginalName());
            $newFilename = str_slug($pathInfo['filename']) . '.' . $pathInfo['extension'];
            $request->file('file')->move($destinationPath, $newFilename);

            $data = '/upload/images/editor/'.$id.'/'.$newFilename;
        }
        else {
            $data = array(
                'message' => 'uploadError',
            );
        }

        return $data;
    }

    //post - ajax/image/{id}/update_alt
    public function updateAlt($id, Request $request) {
        $locale = \App::getLocale();
        $alt_field = 'image_alt_' . $locale;

        if (Image::where('id', $id)->update([$alt_field => $request->input('alt')])) {
            return 1;
        }

        return 0;
    }
}