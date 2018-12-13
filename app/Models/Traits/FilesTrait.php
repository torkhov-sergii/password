<?php namespace App\Models\Traits;

use App\Models\File;

trait FilesTrait {

	//добавить фотки или аватарку
	public function addFile($files, $file_type = null) {
        $newfile_arr = [];
		if(!is_array($files)) $files = [$files];

		foreach($files as $file) {
			$fileModel = new File([], $this);
			$newfile = $fileModel->addFile($file, $file_type);

			$newfile_arr[] = $newfile;
		}

		return $newfile_arr;
	}

	//region RELATION
    public function files($file_type = null) {
        if($file_type) $files = $this->morphMany('App\Models\File', 'subject')->where('file_type', $file_type);
        else $files = $this->morphMany('App\Models\File', 'subject');

        return $files;
    }
	//endregion
}
