@extends('layouts.master')

@section('left_title')
Home
@endsection
@section('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table(['class' => 'table table-bordered table-striped'],true) }}
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')

    <script type="text/javascript"
            src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript"
            rc="{{asset('/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/plugins/datatables-buttons/js/buttons.flash.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <!-- Scripts -->
    <script src="{{asset('assets/plugins/datatables/buttons.server-side.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/datatables.mark.js')}}"></script>
    {!! $dataTable->scripts() !!}
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            mark: true
        });
    </script>
@endsection
