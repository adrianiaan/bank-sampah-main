<?php

namespace App\DataTables;

use App\Models\Transaksi;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class TransaksiDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $user = Auth::user();
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($transaksi) {
                return view('admin.transaksi.action', compact('transaksi'));
            })
            ->addColumn('jenis_sampah', function ($transaksi) {
                return $transaksi->jenisSampah->name;
            })
            ->addColumn('user', function ($transaksi) {
                return $transaksi->user->name;
            })
            ->editColumn('status_verifikasi', function ($row) use ($user) {
                $options = ['terverifikasi', 'ditolak'];
                 if ($user->role === 'kepala_dinas') {
                    // Untuk Kepala Dinas, status ditampilkan sebagai teks biasa tanpa dropdown
                    return $row->status_verifikasi;
                } elseif ($user->role === 'end_user') {
                    // Untuk End_User, status ditampilkan sebagai teks biasa tanpa dropdown
                    return $row->status_verifikasi;
                } elseif ($user->role === 'super_admin') {
                    return $row->status_verifikasi;
                }
                $select = '<select class="form-select form-select-sm status-select" data-id="'.$row->id.'">';
                foreach ($options as $option) {
                    $selected = $row->status_verifikasi === $option ? 'selected' : '';
                    $select .= '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
                }
                $select .= '</select>';
                return $select;
            })
            ->rawColumns(['action', 'status_verifikasi'])
            ->orderColumn('status_verifikasi', function ($query, $direction) {
                $query->orderBy('status_verifikasi', $direction);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transaksi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaksi $model)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $query = $model->newQuery()->with('user')->select('transaksis.*');

        if ($user && $user->role === 'end_user') {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('transaksi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                'excel',
                'csv',
                'reload'
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $columns = [
            Column::make('user')->title('User'),
            Column::make('jenis_sampah')->title('Jenis Sampah'),
            Column::make('berat_kg')->title('Berat (Kg)'),
            Column::make('harga_per_kilo_saat_transaksi')->title('Harga / Kg'),
            Column::make('nilai_saldo')->title('Nilai Saldo'),
            Column::make('catatan_verifikasi')->data('catatan_verifikasi')->name('catatan_verifikasi')->title('Catatan Verifikasi'),
            Column::make('tanggal_transaksi')->title('Tanggal'),
            Column::make('status_verifikasi')->title('Status'),
        ];

        if ($user && $user->role === 'end_user') {
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center');
        } elseif ($user && $user->role === 'kepala_dinas') {
             // Jangan tampilkan kolom aksi untuk Kepala Dinas
        }
         else {
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center');
        }

         

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Transaksi_' . date('YmdHis');
    }
}
