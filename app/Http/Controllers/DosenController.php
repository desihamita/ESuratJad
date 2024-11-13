<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosenPromotion;
use Illuminate\Support\Facades\Validator;


class DosenController extends Controller
{
    public function index()
    {
        $title = 'Surat Dosen';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Dosen', 'url' => ''],
        ];
        $data = DosenPromotion::get();
        
        return view('pages.dosen.index', compact('data','title', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required',
            'jabatan_akademik_sebelumnya' => 'required',
            'jabatan_akademik_di_usulkan' => 'required',
            'tanggal_proses' => 'required',  
            'tanggal_selesai' => 'required', 
            'surat_pengantar_pimpinan_pts' => 'required|file|mimetypes:application/pdf|max:2048',
            'berita_acara_senat' => 'required|file|mimetypes:application/pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $savedFilePath = null;
            $savedFilePathBerita = null;
            if ($request->hasFile('surat_pengantar_pimpinan_pts')) {
                $savedFilePath = $request->file('surat_pengantar_pimpinan_pts')->store('surat_pengantar', 'public');
            } 
            
            if ($request->hasFile('berita_acara_senat')) {
                $savedFilePathBerita = $request->file('berita_acara_senat')->store('berita_acara', 'public');
            }

            DosenPromotion::create([
                'nama_dosen' => $request->nama_dosen,
                'jabatan_akademik_sebelumnya' => $request->jabatan_akademik_sebelumnya,
                'jabatan_akademik_di_usulkan' => $request->jabatan_akademik_di_usulkan,
                'tanggal_proses' => $request->tanggal_proses,
                'tanggal_selesai' => $request->tanggal_selesai,
                'surat_pengantar_pimpinan_pts' => $savedFilePath,
                'berita_acara_senat' => $savedFilePathBerita,
            ]);

            return redirect()->route('dosen.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $dosen = DosenPromotion::find($id);
        if(!$dosen) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        return response()->json($dosen);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required',
            'jabatan_akademik_sebelumnya' => 'required',
            'jabatan_akademik_di_usulkan' => 'required',
            'tanggal_proses' => 'required',
            'tanggal_selesai' => 'required',
            'surat_pengantar_pimpinan_pts' => 'nullable|file|mimetypes:application/pdf|max:2048',
            'berita_acara_senat' => 'nullable|file|mimetypes:application/pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $dosen = DosenPromotion::find($id);

            if ($request->hasFile('surat_pengantar_pimpinan_pts')) {
                $savedFilePath = $request->file('surat_pengantar_pimpinan_pts')->store('surat_pengantar', 'public');
                $dosen->surat_pengantar_pimpinan_pts = $savedFilePath;
            } else {
                $dosen->surat_pengantar_pimpinan_pts = $dosen->surat_pengantar_pimpinan_pts;
            }

            if ($request->hasFile('berita_acara_senat')) {
                $savedFilePathSenat = $request->file('berita_acara_senat')->store('berita_acara', 'public');
                $dosen->berita_acara_senat = $savedFilePathSenat;
            } else {
                $dosen->berita_acara_senat = $dosen->berita_acara_senat;
            }
    
            $dosen->nama_dosen = $request->nama_dosen;
            $dosen->jabatan_akademik_sebelumnya = $request->jabatan_akademik_sebelumnya;
            $dosen->jabatan_akademik_di_usulkan = $request->jabatan_akademik_di_usulkan;
            $dosen->tanggal_proses = $request->tanggal_proses;
            $dosen->tanggal_selesai = $request->tanggal_selesai;
            $dosen->save();
    
            return redirect()->route('dosen.index')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function filter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = DosenPromotion::whereBetween('tanggal_proses', [$startDate, $endDate])->get();
        return response()->json(['data' => $data]);
    }

    public function detail(Request $request, string $id) 
    {
        $dosen = DosenPromotion::findOrFail($id); 
        return response()->json($dosen);
    }
}
