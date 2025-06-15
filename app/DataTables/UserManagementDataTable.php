<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserManagementDataTable extends DataTable
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
        $currentUser = auth()->user();

        if ($currentUser->role !== 'kepala_dinas') {
            $dataTable = $dataTable->addColumn('action', function ($user) use ($currentUser) {
                $editUrl = route('admin.users.edit', $user->id);
                $deleteUrl = route('admin.users.destroy', $user->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');
                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Yakin ingin menghapus pengguna ini?\');">
                        '.$csrf.'
                        '.$method.'
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                ';
            });
        }

        return $dataTable->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', 'name', 'email', 'role');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('user-management-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                'excel',
                'csv',
                [
                    'text' => 'PDF',
                    'action' => 'function ( e, dt, node, config ) {
                        window.open("'.route('admin.users.cetak.pdf').'", "_blank");
                    }',
                    'className' => "btn btn-secondary",
                ],
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
        $currentUser = auth()->user();
        $columns = [
            'name',
            'email',
            'role',
        ];
        if ($currentUser->role !== 'kepala_dinas') {
            $columns[] = ['data' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false];
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
        return 'UserManagement_' . date('YmdHis');
    }
}
