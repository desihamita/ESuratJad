<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosenPromotion;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Laporan';
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/home'],
            ['name' => 'Laporan', 'url' => ''],
        ];
        $data = DosenPromotion::get();

        return view('pages.laporan.laporan', compact('data','title', 'breadcrumbs') );
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

    public function exportPdf(Request $request)
    {
        $query = DosenPromotion::query();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_proses', [$start_date, $end_date]);
        }
        
        $data = $query->get();

        $start_date = Carbon::parse($request->start_date)->format('F Y');
        $end_date = Carbon::parse($request->end_date)->format('F Y');

        $pdf = Pdf::loadView('pages.laporan.pdf', compact('data', 'start_date', 'end_date'))->setPaper('a4');
        return $pdf->download('laporan_data_dosen.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = DosenPromotion::query();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_proses', [$start_date, $end_date]);
        }

        $data = $query->get();

        return Excel::download(new \App\Exports\DosenPromotionExport($data, $start_date, $end_date), 'laporan_data_dosen.xlsx');
    }
}
