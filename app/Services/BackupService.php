<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupService
{
    public function backupDatabase(): string
    {
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port');

        $filename = 'backup_' . date('Y-m-d_His') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        // Create backups directory if it doesn't exist
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Use pg_dump to backup PostgreSQL database
        $command = sprintf(
            'PGPASSWORD=%s pg_dump -h %s -p %s -U %s -d %s -F c -f %s',
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception('Database backup failed: ' . implode("\n", $output));
        }

        return $path;
    }

    public function backupAssets(): string
    {
        $filename = 'assets_backup_' . date('Y-m-d_His') . '.zip';
        $backupPath = storage_path('app/backups/' . $filename);

        // Create backups directory if it doesn't exist
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($backupPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            throw new \Exception('Cannot create zip file');
        }

        // Backup uploads klasörü (gallery, blog, portfolio, slide resimleri)
        $uploadsPath = storage_path('app/public/uploads');
        if (file_exists($uploadsPath)) {
            $this->addDirectoryToZip($uploadsPath, $zip, 'uploads');
        }

        // Backup public/assets klasörü (varsa)
        $assetsPath = public_path('assets');
        if (file_exists($assetsPath)) {
            $this->addDirectoryToZip($assetsPath, $zip, 'assets');
        }

        $zip->close();

        return $backupPath;
    }

    protected function addDirectoryToZip($dir, $zip, $zipPath = '')
    {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $dir . '/' . $file;
                $zipFilePath = $zipPath ? $zipPath . '/' . $file : $file;

                if (is_dir($filePath)) {
                    $zip->addEmptyDir($zipFilePath);
                    $this->addDirectoryToZip($filePath, $zip, $zipFilePath);
                } else {
                    $zip->addFile($filePath, $zipFilePath);
                }
            }
        }
    }
}

