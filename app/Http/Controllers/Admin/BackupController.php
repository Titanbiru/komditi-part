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
        // Pastikan folder ada
        if (!Storage::exists($this->backupPath)) {
            Storage::makeDirectory($this->backupPath);
        }

        $files = collect(Storage::files($this->backupPath))
            ->filter(fn($file) => str_ends_with($file, '.sql'))
            ->map(function($file) {
                return [
                    'name' => basename($file),
                    'size' => round(Storage::size($file) / 1024 / 1024, 2) . ' MB', // Format ke MB
                    'created_at' => Carbon::createFromTimestamp(Storage::lastModified($file))->format('d/m/Y'),
                    'raw_time' => Storage::lastModified($file) // Untuk sorting
                ];
            })->sortByDesc('raw_time')->values();

        $lastBackup = $files->first();

        return view('admin.backup.index', compact('files', 'lastBackup'));
    }

    public function backup()
{
    $filename = 'ecommerce_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
    $directory = storage_path('app/backups');
    
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true);
    }

    $filePath = $directory . DIRECTORY_SEPARATOR . $filename;
    $database = config('database.connections.mysql.database');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');

    // JALUR LENGKAP XAMPP (Biasanya di C:\xampp\mysql\bin\mysqldump.exe)
    // Gunakan tanda kutip ganda untuk path yang ada spasinya
    $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump'; 

    $command = "{$mysqldumpPath} -u {$username} " . ($password ? "-p{$password}" : "") . " {$database} > \"{$filePath}\" 2>&1";
    
    exec($command, $output, $resultCode);

    if ($resultCode !== 0) {
        return back()->with('error', implode(' ', $output));
    }

    return back()->with('success', 'Backup created successfully.'); 
}

    public function download($filename)
    {
        $filePath = $this->backupPath . '/' . $filename;

        if (!Storage::exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::download($filePath);
    }

    public function delete($filename)
    {
        Storage::delete($this->backupPath . '/' . $filename);
        return back()->with('success', 'Backup deleted successfully.');
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

        // Gunakan mysql command untuk restore
        $command = "mysql -u {$username} -p\"{$password}\" {$database} < \"{$filePath}\"";
        
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            return back()->with('error', 'Gagal melakukan restore database.');
        }

        return back()->with('success', 'Database restored successfully.');
    }
}