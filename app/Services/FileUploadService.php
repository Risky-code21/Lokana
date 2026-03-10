<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload single file
     */
    public function uploadFile(UploadedFile $file, string $path, ?string $oldFile = null): string
    {
        // Hapus file lama jika ada
        if ($oldFile) {
            $this->deleteFile($oldFile);
        }

        // Generate nama file unik
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Simpan file
        $filePath = $file->storeAs($path, $filename, 'public');
        
        return Storage::url($filePath);
    }

    /**
     * Upload multiple files
     */
    public function uploadMultipleFiles(array $files, string $path, array $oldFiles = []): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs($path, $filename, 'public');
                $uploadedFiles[] = Storage::url($filePath);
            }
        }

        // Hapus file lama yang tidak dipakai lagi
        if (!empty($oldFiles)) {
            foreach ($oldFiles as $oldFile) {
                $this->deleteFile($oldFile);
            }
        }

        return $uploadedFiles;
    }

    /**
     * Delete file
     */
    public function deleteFile(?string $fileUrl): bool
    {
        if (!$fileUrl) {
            return false;
        }

        $path = str_replace('/storage/', '', parse_url($fileUrl, PHP_URL_PATH));
        
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Delete multiple files
     */
    public function deleteMultipleFiles(array $fileUrls): void
    {
        foreach ($fileUrls as $fileUrl) {
            $this->deleteFile($fileUrl);
        }
    }
}