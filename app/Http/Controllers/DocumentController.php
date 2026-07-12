<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Serve a document file from the public disk.
     * This bypasses the symlink and serves files directly through Laravel,
     * providing better compatibility on Windows and allowing access control.
     */
    public function show(string $filename)
    {
        $path = 'documents/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->response($path);
    }
}
