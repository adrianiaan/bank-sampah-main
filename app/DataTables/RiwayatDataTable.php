<?php

namespace App\DataTables;

use App\Models\Riwayat;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RiwayatDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('jenis_sampah', function ($data) {
                return $data->jenis_sampah->name;
            })
            ->addColumn('harga', function ($data) {
                return 'Rp. ' . $data->jenis_sampah->harga;
            })
            ->addColumn('jumlah', function ($data) {
                return $data->jumlah_kg . ' Kg';
            })
            ->addColumn('lama_penyimpanan', function ($data) {
                return $data->lama_penyimpanan . ' Hari';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Riwayat $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('riwayat-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('name'),
            Column::make('jenis_sampah'),
            Column::make('jumlah'),
            Column::make('harga'),
            Column::make('lama_penyimpanan'),
            Column::make('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Riwayat_' . date('YmdHis');
    }
}
