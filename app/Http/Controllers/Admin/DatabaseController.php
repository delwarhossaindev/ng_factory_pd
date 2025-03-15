<?php

namespace App\Http\Controllers\Admin;

use App\Models\Backup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class DatabaseController extends Controller
{

    /**
     * Summary of exportDatabase
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exportDatabase()
    {
        $dir = 'database';

        is_dir($dir) ?: mkdir(
            $dir,
            0777,
            true
        );
        Backup::truncate();
        $files = File::glob(public_path('database/*.sql'));
        if (count($files)) {
            foreach ($files as $file) {
                $file && unlink($file);
            }
        }

        $db_username = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');
        $db_database = env('DB_DATABASE');

        $name = 'export_' . time() . '.sql';

        $path = public_path('database/');
        $backup_path = $path . $name;

        $backup = new Backup();
        $backup->backup_path = $name;
        $backup->user_id = auth()->id();
        $backup->save();

        exec("mysqldump -u$db_username -p$db_password $db_database > $backup_path");

        return back()->withMessage('Backup generated successfully');
    }

    /**
     * Summary of downloadDatabase
     * @param Backup $backup
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadDatabase(Backup $backup)
    {
        return $backup->downloadDatabaseFile($backup);
    }
}
