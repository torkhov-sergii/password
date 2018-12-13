<?php namespace App\Models;

use App\Libraries\Helpers;
use Illuminate\Database\Eloquent\Model;
use Image as Image2;
use Storage;

//если использовать "\Eloquent" вместо "Model" то работает автокомплит всех методов
class Image extends Model {

    protected $fillable = ['image'];
    protected $object; //объект родитель фотки

    public function __construct(array $attributes = array(), $object = null) {
        $this->object = $object;

        parent::__construct($attributes);
    }

    //добавить фотку или превьюшку
    public function addImage($image, $isPreview = null, $image_type = null) {
//        if(gettype($image) == 'string') {
//            if(file_exists(public_path($image))) {
//                $this->image = $image;
//                $this->image_type = $image_type;
//
//                if ($isPreview) {
//                    $this->isPreview = 1;
//                    $this->destroyAll(1, $image_type);
//                }
//
//                $pathInfo = pathinfo($image);
//
//                $newFilename = str_slug($pathInfo['filename']) . '.' . $pathInfo['extension'];
//                $this->image->instanceWrite('file_name', $newFilename);
//
//                $this->object->images()->save($this);
//
//                ///move file from original dir and rename to slug
//                Storage::disk('paperclip')->copy($image, $this->getPath().$newFilename);
//                Storage::disk('paperclip')->deleteDirectory($this->getPath().'original/');
//            }
//
//            return;
//        }

        if($image) {
            //куда сохранять
            $object_name = Helpers::get_class_name(get_class($this->object));
            $object_id = $this->object['id'];

            $fileInfo = pathinfo($image->getClientOriginalName());
            $basename = $fileInfo['basename'];
            $filename = $fileInfo['filename'];
            $extension = $fileInfo['extension'];

            $newFilename = str_slug(strtolower(mb_substr($filename, 0, 100))) . '.' . $extension;

            if ($isPreview) {
                $this->isPreview = 1;
                $this->destroyAll(1, $image_type);
            }

            $this->subject_id = $object_id;
            $this->subject_type = get_class($this->object);
            $this->image_type = $image_type;
            $this->image_file_name = $newFilename;
            $this->image_file_size = $image->getClientSize();
            $this->image_content_type = $image->getClientMimeType();
            $this->image_content_type = $image->getClientMimeType();

            $this->save();

            //$path = '/upload/images/'.$object_name.'/'.$object_id.'/'.$this->id;
            Storage::disk('paperclip')->putFileAs($this->getPath(), $image, $newFilename);

            return $this;
        }
        return false;
    }

    //получить кеш фотки
    public function getCache($params) {
        $orig_url = $this->getUrl();
        $orig_path = $this->getPath();
        $orig_file_name = $this->image_file_name;

        if(isset($params['w']) && $params['h'] && isset($params['scale'])) {
            $w = $params['w'];
            $h = $params['h'];
            $scale = $params['scale'];

            $cache_path = '/cache/images/'.$w.'_'.$h.'_'.$scale.$orig_path;
            $cache_url = $cache_path.$orig_file_name;

            //если готового файла нет - сгенерить и сохранить
            if (file_exists(public_path($cache_url)) === false) {

                if (file_exists(public_path($orig_url)) === true) {

                    if (!file_exists(public_path($cache_path))) {
                        mkdir(public_path($cache_path), 0777, true);
                    }

                    $img = Image2::make(public_path($orig_url));

                    if($scale == 'crop') $img->fit($w, $h);
                    //if($scale == 'crop') $img->fit($w, $h)->encode('gif', 1);
                    if($scale == 'min') {
                        if($w/$h > $img->getWidth()/$img->getHeight()) {
                            $img->resize($w, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        else {
                            $img->resize(null, $h, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                    }
                    if($scale == 'max') {
                        $img->resize($w, $h, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    }

                    $img->save(public_path($cache_path.$orig_file_name), config('image.quality', 80));

                    return $cache_path.$orig_file_name;
                }
                else {
                    //return url('/i/icon/no_image.png');
                    //return $cache_path.$orig_file_name;
                }
            }
            else {
                return $cache_path.$orig_file_name;
            }
        }
        else {
            return $orig_url;
        }

        //вывести оригинальное фото - ничего не кешировать
        if(isset($params['original']) && $params['original'] == true) {
            return $orig_url;
        }

//        //фото без кеша
//        $add_nocache_to_image = '';
//        if(isset($params['nocache']) && $params['nocache'] == true) {
//            $add_nocache_to_image = '?v='.rand(0, 999999);
//        }
//
//        return '/'.$cache_full_path.$orig_file_name.$add_nocache_to_image;
    }

    //удалить все фото объекта или аватарку
    public function destroyAll($isPreview = null, $image_type = null) {
        if($isPreview) $images = $this->object->preview($image_type);
        elseif($image_type) $images = $this->object->images($image_type);
        else $images = $this->object->images();

        foreach ($images->get() as $image) {
            $image->delete();
            \File::deleteDirectory(public_path().$image->getPath());
        }
    }

    //удалить фото объекта по id
    public function destroyImageById($id) {
        $image = $this->find($id);

        if($image) {
            \File::deleteDirectory(public_path().$image->getPath());

            $image->delete();
        }
    }

    //получить url фотки - /upload/images/user/1/82/1.jpg
    public function getUrl() {
        $filename = $this->image_file_name;
        //$filename = $this->image->originalFilename();

        return $this->getPath().$filename;
    }

    //получить путь фотки - /upload/images/user/1/82/
    public function getPath() {
        $subject_name = Helpers::get_class_name($this['subject_type']);
        $subject_id = $this['subject_id'];
        $id = $this->id;

        return '/upload/images/'.$subject_name.'/'.$subject_id.'/'.$id.'/';
        //return $subject_name.'/'.$subject_id.'/'.$id.'/';
    }

    //получить alt фотки
    public function getAlt() {
        $locale = \App::getLocale();
        $alt_field = 'image_alt_' . $locale;

        return $this->attributes[$alt_field];
    }

    //region RELATION
    public function subject() {
        return $this->morphTo();
    }
    //endregion
}