<?php

namespace App\DataTables;

use App\Models\Jenis_sampah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JenisSampahDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $currentUser = auth()->user();
        $dataTable = new EloquentDataTable($query);

            if ($currentUser->role === 'super_admin') {
                $dataTable = $dataTable->addColumn('action', function ($data) {
                    return view('admin.jenis-sampah.action', compact('data'));
                });
            }

        $dataTable = $dataTable->editColumn('foto', function ($data) {
            $url = $data->foto_url; // gunakan accessor foto_url
            return '<img src="' . $url . '" alt="Foto" style="width: 50px; height: auto;">';
        });

        return $dataTable->rawColumns(['action', 'foto'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Jenis_sampah $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $currentUser = auth()->user();

        $builder = $this->builder()
            ->setTableId('jenissampah-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();

if (in_array($currentUser->role, ['super_admin', 'kepala_dinas'])) {
            $builder = $builder->scrollX(true)
                ->parameters([
                    'dom'          => 'Bfrtip',
                    'buttons'      => [
                        'excel',
                        'csv',
                        [
                            'text' => 'PDF',
                            'action' => 'function ( e, dt, node, config ) {
                                window.open("'.route('jenis_sampah.cetak.pdf').'", "_blank");
                            }',
                            'className' => "btn btn-secondary",
                        ],
                        'reload',
                    ],
                    'scrollY'     => '', // remove vertical scroll to allow table to expand
                ]);
        }

        return $builder;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $currentUser = auth()->user();

        $columns = [
            Column::make('id')->visible(false)->exportable(false)->printable(false),
            Column::make('name'),
            Column::make('kategori'),
            Column::make('deskripsi'),
            Column::make('foto'),
            Column::make('harga')->title('Harga Per Kg')->width(100),
        ];

        if ($currentUser->role === 'super_admin') {
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center');
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'JenisSampah_' . date('YmdHis');
    }
}
