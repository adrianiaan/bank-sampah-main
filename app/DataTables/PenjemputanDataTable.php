<?php

namespace App\DataTables;

use App\Models\Penjemputan;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

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

        return $dataTable
            ->addColumn('action', function ($row) {
                $editUrl = route('penjemputan.edit', $row->id);
                $deleteUrl = route('penjemputan.destroy', $row->id);
                $jadwalFormatted = date('Y-m-d\TH:i', strtotime($row->jadwal));
                $buttons = '<button type="button" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$row->id.'" data-jadwal="'.$jadwalFormatted.'" data-status="'.$row->status.'" data-lokasi="'.$row->lokasi_koordinat.'" data-alamat="'.htmlspecialchars($row->alamat).'">Edit</button>';
                $buttons .= '<form action="'.$deleteUrl.'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\');">';
                $buttons .= csrf_field();
                $buttons .= method_field('DELETE');
                $buttons .= '<button type="submit" class="btn btn-sm btn-danger">Hapus</button>';
                $buttons .= '</form>';
                return $buttons;
            })
            ->editColumn('status', function ($row) {
                $options = ['Terjadwal', 'Selesai', 'Batal'];
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
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Penjemputan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Penjemputan $model)
    {
        return $model->newQuery()->with('user')->select('penjemputan.*');
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
        return [
            'id',
            ['data' => 'user.name', 'name' => 'user.name', 'title' => 'Pengguna'],
            'jadwal',
            'status',
            //'lokasi_koordinat',
            'alamat',
            ['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false],
        ];
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
