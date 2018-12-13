<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Helpers;
use Storage;

class File extends Model {

	protected $fillable = ['file'];
	protected $object; //объект родитель файла

	public function __construct(array $attributes = array(), $object = null) {
		$this->object = $object;

		parent::__construct($attributes);
	}

	//добавить фотку или превьюшку
	public function addFile($file, $file_type = null) {
		if($file) {
            if(gettype($file) == 'string') {
//                if(file_exists(public_path($file))) {
//                    $pathInfo = $file;
//                    $filename = explode('/',$pathInfo);
//                    $filename = array_reverse($filename);
//                    $filename = $filename[0];
//                    $extension = explode('.',$filename);
//                    $extension = $extension[1];
//
//                    $filename_without_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
//                    $newFilename = str_slug($filename_without_ext) . '.' . $extension;
//
//                    //$this->file->instanceWrite('file_name', $newFilename);
//                    //$this->file->instanceWrite('file_name_original', $filename);
//
//                    $this->object->files()->save($this);
//
//                    ///move file from original dir and rename to slug
//                    Storage::disk('paperclip')->copy($file, $this->getPath().$newFilename);
//                    Storage::disk('paperclip')->deleteDirectory($this->getPath().'original/');
//                }
            }
            else {
                //куда сохранять
                $object_name = Helpers::get_class_name(get_class($this->object));
                $object_id = $this->object['id'];

                $fileInfo = pathinfo($file->getClientOriginalName());
                $basename = $fileInfo['basename'];
                $filename = $fileInfo['filename'];
                $extension = $fileInfo['extension'];

                $newFilename = str_slug(strtolower(mb_substr($filename, 0, 80))) . '.' . $extension;

                $this->subject_id = $object_id;
                $this->subject_type = get_class($this->object);
                $this->file_type = $file_type;
                $this->file_file_name = $newFilename;
                $this->file_file_name_original = $basename;
                $this->file_file_size = $file->getClientSize();
                $this->file_content_type = $file->getClientMimeType();

                $this->save();

                Storage::disk('paperclip')->putFileAs($this->getPath(), $file, $newFilename);
            }

			return $this;
		}
		return false;
	}

	//получить имя файла - 1.txt
	public function getName() {
        return $this->file_file_name;
		//return $this->file->originalFilename();
	}

	//получить url файла - /upload/files/task/1/82/1.txt
	public function getUrl() {
		return $this->getPath().$this->getName();
	}

	//получить путь файла - /upload/images/user/1/82/
	public function getPath() {
		$subject_name = Helpers::get_class_name($this['subject_type']);
		$subject_id = $this->subject_id;
		$id = $this->id;

        return '/upload/files/'.$subject_name.'/'.$subject_id.'/'.$id.'/';
	}

    //удалить файл по id
    public function destroy_file($id) {
        $file = $this->find($id);

        if($file) {
            \File::deleteDirectory(public_path().$file->getPath());

            $file->delete();
        }
    }

	//region RELATION
	public function subject() {
		return $this->morphTo();
	}
	//endregion
}
