@extends('layouts.master')

@section('title')
impor
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Form Data Potongan Payroll Mulia</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                    <li class="breadcrumb-item">Potongan Payroll</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <div id="buttonExport" class="pull-right"></div>
                        {{-- <a href="{{ route('export.potongan_hrd') }}" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-file-excel"></i> Cetak Excel</a> --}}
                        <a onclick="cetakexcel()" class="btn btn-info btn-sm" style="float: right"><i class="fa fa-file-excel"></i> Cetak Excel</a>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2">
                        Bulan<br>
                        <select class="form-control" name="bulan" id="bulan" onchange="payroll()">
                            @for ($i = 1; $i <= 12; $i++) @if ($bulan !='' ) @if ($bulan==$i) <option selected value="{{ $i }}">{{ FunctionHelper::bulan($i) }}
                                </option>
                                @else
                                <option value="{{ $i }}">{{ FunctionHelper::bulan($i) }}</option>
                                @endif
                                @else
                                <option value="{{ $i }}">{{ FunctionHelper::bulan($i) }}</option>
                                @endif
                                @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        Tahun <br>
                        <select class="form-control" name="tahun" id="tahun" onchange="payroll()">
                            @for ($i = date('Y'); $i >= date('Y') - 20; $i--)
                            @if ($tahun != '')
                            @if ($tahun == $i)
                            <option selected value="{{ $i }}">{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('includes.alert')
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100 scrollmenu">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">No</th> -->
                            <th class="text-center">KODE PC</th>
                            <th class="text-center">KDPEG</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">TOTAL POTONGAN</th>
                            <th class="text-center">POTONGAN KOPERASI</th>
                            <th class="text-center">POTONGAN SEMBAKO</th>
                            <th class="text-center">POTONGAN SIMPAS</th>
                            <th class="text-center">POTONGAN DKM</th>
                            <th class="text-center">SISA POTONGAN</th>
                            <th class="text-center">POTONGAN POKOK</th>
                            <th class="text-center">POTONGAN WAJIB</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<form id="delete-form" method="post">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('css')
<!-- DataTables -->
<link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets') }}/sweetalert/sweetalert.css">

<style>
    td {
        font-size: 11px !important;
    }

    .text-right {
        text-align: right !important;
    }
</style>
@endsection

@section('footscript')
<!-- Required datatable js -->
<link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
<script src="{{ asset('packages/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/currency.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/financial.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/libs/jszip/jszip.min.js"></script>
<script src="{{ asset('assets') }}/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('assets') }}/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/parsley.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<!-- Responsive examples -->
<script src="{{ asset('assets') }}/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets') }}/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="{{ asset('js') }}/fungsi.js"></script>

<script>
    
    var buttonCommon = {
        exportOptions: {
            format: {
                body: function(data, row, column, node) {
                    // Strip $ from salary column to make it numeric
                    html = $.fn.DataTable.Buttons.stripData(data, null);
                    // now apply your own formatting ...

                    return html;
                }
            }
        }
    };
    payroll();
    function payroll() {
        var bulan = $('#bulan').val()
        var tahun = $('#tahun').val()
        // var dt = $('#datatable').DataTable({
        //     "processing": true,
        //     "serverSide": true,
        //     "ajax": {
        //         "url": "{{ route('datatable.potonganHRD') }}",
        //         "dataType": "json",
        //         "data": {
        //             "bulan": bulan,
        //             "tahun": tahun,
        //         }
        //     },
        //     "columns": [{
        //             "data": "kode_profit"
        //         },
        //         {
        //             "data": "no_anggota"
        //         },
        //         {
        //             "data": "nama"
        //         },
        //         {
        //             "data": "total_potongan"
        //         },
        //         {
        //             "data": "potongan_koperasi"
        //         },
        //         {
        //             "data": "potongan_sembako"
        //         },
        //         {
        //             "data": "potongan_simpas"
        //         },
        //         {
        //             "data": "potongan_dkm"
        //         },
        //         {
        //             "data": "sisa_potongan"
        //         },
        //         {
        //             "data": "potongan_pokok"
        //         },
        //         {
        //             "data": "potongan_wajib"
        //         },
        //     ],
        //     "columnDefs": [{
        //             "className": 'text-center',
        //             "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        //         },
        //         {
        //             "searchable": false,
        //             "targets": [0, 1, 3, 4, 5, 6, 7, 8, 9, 10]
        //         },
        //         {
        //             "orderable": false,
        //             "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        //         }
        //     ],
        // });

        dt = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "{{ route('datatable.potonganHRD') }}",
                dataType: "json",
                data: {
                    bulan: bulan,
                    tahun: tahun,
                }
            },
            // dom: 'Bfrtip',
            columns: [{
                    data: "kode_profit"
                },
                {
                    data: "no_anggota"
                },
                {
                    data: "nama"
                },
                {
                    data: "total_potongan"
                },
                {
                    data: "potongan_koperasi"
                },
                {
                    data: "potongan_sembako"
                },
                {
                    data: "potongan_simpas"
                },
                {
                    data: "potongan_dkm"
                },
                {
                    data: "sisa_potongan"
                },
                {
                    data: "potongan_pokok"
                },
                {
                    data: "potongan_wajib"
                },
            ],
            // columnDefs: [{
            //         className: 'text-center',
            //         targets: [0, 1, 4, 5, 6]
            //     },
            //     {
            //         searchable: false,
            //         targets: [0, 5, 6]
            //     },
            //     {
            //         orderable: false,
            //         targets: [0, 5, 6]
            //     }
            // ],
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
                {
                    searchable: false,
                    targets: [0, 3, 4, 5, 6, 7, 8, 9, 10]
                },
                {
                    orderable: false,
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            ],
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'excelHtml5',
                    exportOptions: {
                        stripHtml: false
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        stripHtml: false,
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    customize: function(doc) {

                        // doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content[1].table.widths = ['5%', '5%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%'];
                        var rowCount = document.getElementById("datatable").rows.length;
                        for (i = 0; i < rowCount; i++) {
                            doc.content[1].table.body[i][0].alignment = 'center';
                            doc.content[1].table.body[i][1].alignment = 'center';
                            doc.content[1].table.body[i][3].alignment = 'center';
                            doc.content[1].table.body[i][4].alignment = 'center';
                            doc.content[1].table.body[i][5].alignment = 'center';
                            doc.content[1].table.body[i][6].alignment = 'center';
                            doc.content[1].table.body[i][7].alignment = 'center';
                            doc.content[1].table.body[i][8].alignment = 'center';
                            doc.content[1].table.body[i][9].alignment = 'center';
                            doc.content[1].table.body[i][10].alignment = 'center';
                        };
                        doc.pageMargins = [10, 10, 10, 10];
                        doc.defaultStyle.fontSize = 9;
                        doc.styles.tableHeader.fontSize = 9;

                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) {
                            return .5;
                        };
                        objLayout['vLineWidth'] = function(i) {
                            return .5;
                        };
                        objLayout['hLineColor'] = function(i) {
                            return '#aaa';
                        };
                        objLayout['vLineColor'] = function(i) {
                            return '#aaa';
                        };
                        objLayout['paddingLeft'] = function(i) {
                            return 4;
                        };
                        objLayout['paddingRight'] = function(i) {
                            return 4;
                        };
                        doc.content[0].layout = objLayout;
                    }
                })
            ]
            })
            .buttons()
            .container()
            .appendTo("#buttonExport");
    }

    function cetakexcel() {
        var bulan = $('#bulan').val()
        var tahun = $('#tahun').val()
        var url = '{{ route("export.potongan_hrd") }}?bulan=' + bulan + '&tahun=' + tahun;
        location.href = url;
    }

    
</script>
@endsection