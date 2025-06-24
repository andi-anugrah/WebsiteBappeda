<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'all');
        $search = $request->get('search');

        $documents = Document::query()
            ->byKategori($kategori)
            ->search($search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $documents->appends([
            'kategori' => $kategori,
            'search' => $search
        ]);

        $kategoriOptions = Document::getKategoriOptions();
        $pageTitle = "";
        // Ambil nama kategori dari options jika tersedia
        if ($kategori !== 'all' && isset($kategoriOptions[$kategori])) {
            $pageTitle = $kategoriOptions[$kategori];
        } else {
            $pageTitle = 'Dokumen';
        }


        return view('dokumen', compact('pageTitle', 'documents', 'kategoriOptions', 'kategori', 'search'));
    }


    public function download($id)
    {
        $document = Document::findOrFail($id);
        
        if (!$document->file_dokumen || !Storage::disk('public')->exists($document->file_dokumen)) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($document->file_dokumen);
        $fileName = $document->original_filename ?? 'document.' . pathinfo($document->file_dokumen, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }

    public function show($kategori = null)
    {
        // Redirect to index with kategori parameter
        if ($kategori && in_array($kategori, array_keys(Document::getKategoriOptions()))) {
            return redirect()->route('dokumen', ['kategori' => $kategori]);
        }

        return redirect()->route('dokumen');
    }
}