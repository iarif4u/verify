<?php

namespace App\DataTables;

use App\Model\Mobile;
use App\Purchase;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PurchasesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Purchase $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Purchase $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('mobiles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->processing(false)
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('code'),
            Column::make('host'),
            Column::make('licence'),
            Column::make('ip'),
            Column::make('buyer'),
            Column::make('supported_until')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Purchase_' . date('YmdHis');
    }

    protected function getBuilderParameters()
    {
        return [
            'dom' => '<"top"l>frt<"bottom">Bpi<"clear">',
            'buttons' => ['csv', 'excel', 'print', 'reset', 'reload'],
        ];
    }

}
