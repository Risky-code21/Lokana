<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class MediaService
{
    /**
     *  Function untuk mengupload foto ke disk, saat ini masih disk lokal belum CDN
     *
     * @param Model $model
     * @param UploadedFile $file
     * @param string $folder
     * @param boolean $thumbnail
     * @return Model
     */
    public function upload(Model $model, UploadedFile $file, string $folder, bool $thumbnail = false): Model
    {
        // 1. Validasi Extension (Wajib agar tidak upload file .php/.exe)
        $allowedExtensions = ['webp', 'png', 'jpg', 'jpeg'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception('Format file tidak valid.');
        }

        // 2. Generate Nama File dari ISI FILE (Hashing)
        // md5_file() akan membaca bit-per-bit isi file.
        // Jika user upload foto yang SAMA PERSIS, hash-nya pasti sama.
        $fileHash = md5_file($file->getRealPath());

        // Nama file jadi: "ab12345cd6789.jpg" (Sangat aman & bersih)
        $filename = $fileHash . '.' . $extension;
        $path = "$folder/$filename";

        // 3. LOGIKA DEDUPLIKASI (Poin Utama Anda)
        // Cek apakah file ini sudah ada di storage?
        if (Storage::disk('public')->exists($path)) {
            // STOP! Jangan upload ulang fisiknya. Hemat Storage!

            // TAPI... Kita tetap harus mencatatnya di Database agar Artikel baru
            // tetap punya referensi ke gambar lama tersebut.
            return $model->medias()->create([
                'url' => $path,
                'is_thumbnail' => $thumbnail,
            ]);
        }

        // 4. Jika file belum ada, baru kita simpan fisiknya
        $file->storeAs($folder, $filename, 'public');

        // 5. Simpan ke Database
        return $model->medias()->create([
            'url' => $path,
            'is_thumbnail' => $thumbnail,
        ]);
    }

    /**
     *  Function untuk menghapus foto article
     *
     *  @param Model $model
     *  @return boolean
     */
    public function delete(Model $model): bool
    {
        // Hapus record di DB, tapi HATI-HATI hapus file fisiknya.
        // Karena file fisik mungkin dipakai oleh artikel lain (karena sistem deduplikasi tadi).
        // Untuk tahap awal, aman hapus record DB saja, atau gunakan teknik "Reference Counting" (Advanced).

        foreach ($model->medias as $media) {
            $media->delete(); // Hapus link gambar ke artikel ini
        }

        return true;
    }
}
