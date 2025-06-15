<?php

namespace App\DataTables;

use App\Models\Penjemputan;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Support\Facades\Auth;

class PenjemputanDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $user = Auth::user();

        return $dataTable
            ->addColumn('action', function ($row) use ($user) {
                if ($user->role === 'super_admin' || $user->role === 'end_user') {
                    $editUrl = route('penjemputan.edit', $row->id);
                    $deleteUrl = route('penjemputan.destroy', $row->id);
                    $buttons = '<a href="'.$editUrl.'" class="btn btn-sm btn-primary me-1">Edit</a>';
                    if ($user->role === 'super_admin') {
                        $buttons .= '<form action="'.$deleteUrl.'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\');">';
                        $buttons .= csrf_field();
                        $buttons .= method_field('DELETE');
                        $buttons .= '<button type="submit" class="btn btn-sm btn-danger">Hapus</button>';
                        $buttons .= '</form>';
                    }
                    return $buttons;
                }
                return ''; // Kepala Dinas tidak melihat tombol aksi
            })
            ->editColumn('status', function ($row) use ($user) {
                $options = ['Terjadwal', 'Selesai', 'Batal'];
                if ($user->role === 'kepala_dinas') {
                    // Untuk Kepala Dinas, status ditampilkan sebagai teks biasa tanpa dropdown
                    return $row->status;
                } elseif ($user->role === 'end_user') {
                    // Untuk End_User, status ditampilkan sebagai teks biasa tanpa dropdown
                    return $row->status;
                }
                $select = '<select class="form-select form-select-sm status-select" data-id="'.$row->id.'" data-jadwal="'.$row->jadwal.'" data-lokasi="'.$row->lokasi_koordinat.'" data-alamat="'.htmlspecialchars($row->alamat).'">';
                foreach ($options as $option) {
                    $selected = $row->status === $option ? 'selected' : '';
                    $select .= '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
                }
                $select .= '</select>';
                return $select;
            })
            ->editColumn('user.name', function ($row) {
                return $row->user ? $row->user->name : 'N/A';
            })
            ->rawColumns(['action', 'status'])
            ->with('userRole', function () {
                return \Illuminate\Support\Facades\Auth::user()->role;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Penjemputan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Penjemputan $model)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $query = $model->newQuery()->with('user')->select('penjemputan.*');

        if ($user && $user->role === 'end_user') {
            // End_User hanya melihat data miliknya sendiri
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
            ->setTableId('penjemputan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
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
        $columns = [];

            if ($user && $user->role === 'super_admin') {
                $columns = [
                    ['data' => 'id', 'visible' => false],
                    ['data' => 'user.name', 'name' => 'user.name', 'title' => 'Pengguna'],
                    'jadwal',
                    'status',
                    //'lokasi_koordinat',
                    'alamat',
                ];
                $columns[] = ['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false];
            } elseif ($user && $user->role === 'end_user') {
                $columns = [
                    ['data' => 'user.name', 'name' => 'user.name', 'title' => 'Pengguna'],
                    'jadwal',
                    'status',
                    //'lokasi_koordinat',
                    'alamat',
                    ['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false],
                ];
            } else {
                $columns = [
                    ['data' => 'id', 'visible' => false],
                    ['data' => 'user.name', 'name' => 'user.name', 'title' => 'Pengguna'],
                    'jadwal',
                    'status',
                    //'lokasi_koordinat',
                    'alamat',
                ];
            }

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    public function filename(): string
    {
        return 'Penjemputan_' . date('YmdHis');
    }
}
