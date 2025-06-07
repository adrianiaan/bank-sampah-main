<?php

namespace App\Http\Controllers;

use App\Charts\TrendSampah;
use App\DataTables\RiwayatDataTable;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(RiwayatDataTable $datatable)
    {

        $organikCount = Riwayat::whereHas('jenis_sampah', function ($query) {
            $query->where('kategori', 'Organik');
        })->count();
        $anorganikCount = Riwayat::whereHas('jenis_sampah', function ($query) {
            $query->where('kategori', 'Anorganik');
        })->count();
        $bahanBahayaCount = Riwayat::whereHas('jenis_sampah', function ($query) {
            $query->where('kategori', 'Bahan Berbahaya');
        })->count();
        $chart = new TrendSampah;
        $chart->labels(['Organik', 'Anorganik', 'Bahan Berbahaya']);
        $chart->dataset('Bpje', 'doughnut', [$organikCount, $anorganikCount, $bahanBahayaCount])->backgroundColor(['#ffc107', '#14abef', '#FF6200', '#15CA20', '#FF0022']);
        $chart->options([
            'legend' => [
                'display' => false,
            ]
        ]);
        $title = 'Kalkulator Bank Sampah';
        return $datatable->render('kalkulator', ['title' => $title, 'chart' => $chart]);
    }
}
