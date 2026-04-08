<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BackupController extends Controller
{
    private $backupPath = 'backups';

    public function index()
    {
        $directory = storage_path('app/backups');

        // Pastikan folder ada
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Ambil file pakai File facade biar sama dengan cara simpan tadi
        $files = collect(File::files($directory))
            ->filter(fn($file) => $file->getExtension() === 'sql')
            ->map(function($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => $this->formatSize($file->getSize()),
                    'created_at' => Carbon::createFromTimestamp($file->getMTime())->format('d/m/Y H:i'),
                    'raw_time' => $file->getMTime()
                ];
            })->sortByDesc('raw_time')->values();

        $lastBackup = $files->first();

        return view('admin.backup.index', compact('files', 'lastBackup'));
    }

    public function backup()
    {
        $filename = 'Komditi_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $directory = storage_path('app/backups');
        
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filePath = $directory . DIRECTORY_SEPARATOR . $filename;
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $mysqldumpPath = PHP_OS_FAMILY === 'Windows' 
            ? '"D:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump"' 
            : 'mysqldump'; 

        $passArg = $password ? "-p\"{$password}\"" : "";
        $command = "{$mysqldumpPath} -u {$username} {$passArg} {$database} > \"{$filePath}\" 2>&1";
        
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            return back()->with('error', 'Gagal backup: ' . implode(' ', $output));
        }

        // KEMBALIKAN KE HALAMAN INDEX DENGAN NOTIF (File akan muncul di tabel)
        return back()->with('success', 'Backup #' . $filename . ' berhasil dibuat!'); 
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file',
            'confirm' => 'required',
        ]);

        $filePath = $request->file('backup_file')->getRealPath();
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // SESUAIKAN JUGA PATH RESTORE-NYA KE LARAGON D:
        $mysqlPath = PHP_OS_FAMILY === 'Windows' 
            ? '"D:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql"' 
            : 'mysql';

        $passArg = $password ? "-p\"{$password}\"" : "";

        $command = "{$mysqlPath} -u {$username} {$passArg} {$database} < \"{$filePath}\" 2>&1";
        
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            return back()->with('error', 'Gagal Restore: ' . implode(' ', $output));
        }

        return back()->with('success', 'Database berhasil dikembalikan ke kondisi cadangan!');
    }

    public function download($filename)
    {
        $filePath = storage_path('app/backups/' . $filename);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File fisik gak ketemu di: ' . $filePath);
        }

        return response()->download($filePath);
    }
    public function delete($filename)
    {
        // Gunakan File facade karena kita simpan manual di storage_path
        $filePath = storage_path('app/backups/' . $filename);
        
        if (File::exists($filePath)) {
            File::delete($filePath);
            return back()->with('success', 'File backup berhasil dihapus.');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    
    private function formatSize($bytes) {
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        return number_format($bytes / 1024, 2) . ' KB';
    }
}