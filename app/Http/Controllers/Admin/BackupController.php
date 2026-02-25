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
        $files = collect(Storage::files($this->backupPath))
        ->filter(fn($file) => str_ends_with($file, '.sql'))
        ->map(function($file) {
            return [
                'name' => basename($file),
                'size' => Storage::size($file),
                'created_at' => Carbon::createFromTimestamp(Storage::lastModified($file))->format('d/m/y'),
            ];
        })->sortByDesc('created_at')->values();
        $lastBackup = $files->first();

        return view('admin.backups.index', compact('files', 'lastBackup'));
    }

    public function backup()
    {
        $filename = 'komditi_backup_' . now()->format('Ymd_His') . '.sql';
        $filePath = storage_path('app/' . $this->backupPath . '/' . $filename);

        if (!File::exists(storage_path('app/' . $this->backupPath))) {
            File::makeDirectory(storage_path('app/' . $this->backupPath), 0755, true);
        }

        $database = config('database.connections.mysql.databse');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $command = "mysqldump -u {$username} -p{$password} {$database} > {$filePath}";
        exec($command);

        return back()->with('success', 'Backup created successfully.'); 
    }

    public function download($filename)
    {
        $filePath = storage_path('app/' . $this->backupPath . '/' . $filename);

        if (!File::exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        return response()->download($filePath);
    }

    public function delete($filename)
    {
        Storage::delete($this->backupPath . '/' . $filename);

        return back()->with('success', 'Backup deleted successfully.');
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql',
            'confirm' => 'required',
        ]);

        $filePath = $request->file('backup_file')->getRealPath();
        $database = config('database.connections.mysql.databse');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $command = "mysql -u {$username} -p{$password} {$database} < {$filePath}";
        exec($command);

        return back()->with('success', 'Database restored successfully.');
    }
}
