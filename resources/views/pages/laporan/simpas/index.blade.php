@extends('layouts.master')

@section('title')
    Data Simpanan Pasti
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Data Simpanan Pasti</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data</a></li>
                        <li class="breadcrumb-item active">Simpanan Pasti</li>
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

                        <div class="col-md-6">
                            <h4 class="card-title">List Data Simpanan Pasti</h4>
                            <p class="card-title-desc">Data berasal dari Sumber yang tersimpan dalam database</code>.</p>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('data.anggota.create') }}" class="btn btn-info btn-sm" style="float: right"><i
                                    class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.alert')
                    <div class="row mb-2">
                        <div class="col-md-2">
                            Bulan<br>
                            <select class="form-control" name="bulan" id="bulan" onchange="ssb()">
                                @for ($i = 1; $i <= 12; $i++)
                                    @if ($bulan != '')
                                        @if ($bulan == $i)
                                            <option selected value="{{ $i }}">{{ FunctionHelper::bulan($i) }}
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
                            <select class="form-control" name="tahun" id="tahun" onchange="ssb()">
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
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4 text-right">
                            &nbsp;<br>
                            {{-- <button class="btn btn-sm btn-success"><i class="fas fa-download"></i> Unduh Laporan</button> --}}
                            <div id="buttonExport" class="pull-right"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            Sampai
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-2">
                            Bulan<br>
                            <select class="form-control" name="bulan_end" id="bulan_end" onchange="simpanan()">
                                @for ($i = 1; $i <=12; $i++) @if ($bulan !='' ) @if ($bulan==$i) <option selected value="{{ $i }}">{{ FunctionHelper::bulan($i) }}</option>
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
                            <select class="form-control" name="tahun_end" id="tahun_end" onchange="simpanan()">
                                @for ($i = date('Y'); $i >=(date('Y')-20); $i--)
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
                    <hr>
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jatuh Tempo</th>
                                <th>No. Rekening</th>
                                <th>No Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Unit Kerja</th>
                                <th>Nilai Simpanan</th>
                            </tr>
                        </thead>
                    </table>
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
    <link href="{{ asset('assets') }}/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets') }}/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
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
    <script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>

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
                        html = $.fn.DataTable.Buttons.stripData(data, null);
                        return html;
                    }
                }
            }
        };

        ssb()

        function ssb() {
            var tahun = $('#tahun').val()
            var bulan = $('#bulan').val()
            var tahun_end = $('#tahun_end').val()
            var bulan_end = $('#bulan_end').val()
            var dt = $('#datatable').DataTable({
                    searching: false,
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: "{{ route('datatable.laporan.simp-ssb') }}",
                        dataType: "json",
                        data: {
                            bulan: bulan,
                            tahun: tahun,
                            bulan_end: bulan_end,
                            tahun_end: tahun_end,
                        }
                    },
                    dom: 'Bfrtip',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: "tgl_jatuh_tempo",
                            name: 'created_at'
                        },
                        {
                            data: "no_rekening"
                        },
                        {
                            data: "no_anggota"
                        },
                        {
                            data: "nama"
                        },
                        {
                            data: "unit_kerja"
                        },
                        {
                            data: "nilai_simpanan"
                        },

                    ],
                    columnDefs: [{
                            className: 'text-center',
                            // targets: [0, 1, 4, 5, 6]
                        },
                        // {
                        //     searchable: false,
                        //     targets: [0, 5, 6]
                        // },
                        // {
                        //     orderable: false,
                        //     targets: [0, 5, 6]
                        // }
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
                                // columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            customize: function(doc) {

                                // doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                doc.content[1].table.widths = ['5%', '10%', '15%', '25%', '15%', '15%',
                                    '15%'
                                ];
                                var rowCount = document.getElementById("datatable").rows.length;
                                for (i = 0; i < rowCount; i++) {
                                    doc.content[1].table.body[i][0].alignment = 'center';
                                    doc.content[1].table.body[i][1].alignment = 'center';
                                    doc.content[1].table.body[i][3].alignment = 'center';
                                    doc.content[1].table.body[i][4].alignment = 'center';
                                    doc.content[1].table.body[i][5].alignment = 'center';
                                    doc.content[1].table.body[i][6].alignment = 'center';
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
    </script>
@endsection

@section('modal')
@endsection
