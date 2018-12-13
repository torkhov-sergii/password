<?php namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

class BackupController extends Controller {

    protected $backup_folder; // куда будут сохранятся файлы
    protected $delay_delete = 0; // время жизни архива (в секундах)
    protected $url = ''; // site url

    public function __construct()
    {
        $this->backup_folder = $_SERVER['DOCUMENT_ROOT'].'/public/backup'; // куда будут сохранятся файлы
        $this->url = str_replace('http://','', env('APP_URL'));
    }

    public function backupIndex() {
        $deleteOld = $this->deleteOldArchives($this->backup_folder, $this->delay_delete);    // удаляем старые архивы

        return view('admin.backup.index', compact('mail_message'));
    }

    public function createFiles() {
        $backup_name = $this->url.'_backup_' . date("Y-m-d"); // имя архива
        $dir = $_SERVER['DOCUMENT_ROOT']; // что бэкапим // - /

        $start = microtime(true);    // запускаем таймер

        $doBackupFiles = $this->backupFiles($this->backup_folder, $backup_name, $dir);    // делаем бэкап файлов

        // добавляем в письмо отчеты
        $message = '';
        if ($doBackupFiles) {
            $message .= '<h2>Файлы бекапа успешно созданы</h2><br/>';
            //$mail_message .= 'Files: <a href="http://' . $this->url.'/backup/'.$doBackupFiles . '">' . $doBackupFiles . '</a><br/>';
            $message .= 'Files: <a href="'.'/backup/'.$doBackupFiles.'">' . $doBackupFiles . '</a><br/>';
        }

        $time = microtime(true) - $start;     // считаем время, потраченое на выполнение скрипта
        $message .= '<br>script time: ' . $time . '<br><br><br>';

        return view('admin.backup.index', compact('message'));
    }

    public function createBd() {
        $db_host = env('DB_HOST');
        $db_user = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');
        $db_name = env('DB_DATABASE');

        $backup_name = $this->url.'_backup_' . date("Y-m-d");    // имя архива

        $start = microtime(true);    // запускаем таймер

        $doBackupDB = $this->backupDB($this->backup_folder, $backup_name, $db_host, $db_user, $db_password, $db_name);    // и базы данных

        $message = '';
        if ($doBackupDB) {
            $message .= '<h2>Файлы бекапа успешно созданы</h2><br/>';
            $message .= 'DB: <a href="http://' . $this->url.'/backup/'.$doBackupDB . '">' . $doBackupDB . '</a><br/>';
        }

        $time = microtime(true) - $start;     // считаем время, потраченое на выполнение скрипта
        $message .= '<br>script time: ' . $time . '<br><br><br>';

        return view('admin.backup.index', compact('message'));
    }

    private function backupFiles($backup_folder, $backup_name, $dir)
    {
        $fullFileName = $backup_folder . '/' . $backup_name . '.tar.gz';
        $dir = str_replace('/public','',$dir);
        shell_exec("tar -cvf " . $fullFileName . " --exclude vendor " . $dir . "/* ");
        return $backup_name . '.tar.gz';
    }

    private function backupDB($backup_folder, $backup_name, $db_host, $db_user, $db_password, $db_name)
    {
        $fullFileName = $backup_folder . '/' . $backup_name . '.sql';
        $command = 'mysqldump -h' . $db_host . ' -u' . $db_user . ' -p' . $db_password . ' ' . $db_name . ' > ' . $fullFileName;
        shell_exec($command);
        return $backup_name . '.sql';
    }

    private function deleteOldArchives($backup_folder, $delay_delete)
    {
        $this_time = time();
        $files = glob($backup_folder . "/*.tar.gz*");
        $deleted = array();
        foreach ($files as $file) {
            if ($this_time - filemtime($file) > $delay_delete) {
                array_push($deleted, $file);
                unlink($file);
            }
        }
        return $deleted;
    }
}
