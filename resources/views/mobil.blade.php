@extends('layouts.template_index')

@section('header', 'Data Mobil')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endsection

@section('content')

    <div id="controller">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a type="button" class="btn btn-primary mb-2" @click="addData()"><i class="fas fa-plus"></i>
                                Tambah Mobil</a>
                        </div>

                        <div class="card-body">

                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px" class="text-center">No.</th>
                                        <th class="text-center">Merk</th>
                                        <th class="text-center">Model</th>
                                        <th class="text-center">Plat Nomor</th>
                                        <th class="text-center">Tarif</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="url" method="post" @submit="submitForm($event, data.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Mobil</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                                <label>Merk</label>
                                <input type="text" name="merk" :value="data.merk"
                                    class="form-control @error('merk') is-invalid @enderror" required>
                                @error('merk')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Model</label>
                                <input type="text" name="model" :value="data.model"
                                    class="form-control @error('model') is-invalid @enderror" required>
                                @error('model')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Plat Nomor</label>
                                <input type="text" name="plat" :value="data.plat"
                                    class="form-control @error('plat') is-invalid @enderror" required>
                                @error('plat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tarif</label>
                                <input type="text" name="tarif" :value="data.tarif"
                                    class="form-control @error('tarif') is-invalid @enderror" required>
                                @error('tarif')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>


@endsection

@section('js')
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script src="{{ asset('assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        var url = '{{ url('mobil') }}';
        var apiUrl = '{{ url('api/mobil') }}';

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: false
            }, {
                data: 'merk',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'model',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'plat',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'tarif',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'status',
                class: 'text-center',
                orderable: false
            },
            {
                render: function(index, row, data, meta) {
                    return `
                <a href="#" class="btn btn-primary btn-sm" onclick="controller.editData(event, ${meta.row})"><i class="fas fa-edit"></i> Edit</a>
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})"><i class="fas fa-trash"></i> Delete</a>
            `
                },
                orderable: false,
                class: 'text-center'
            },
        ];

        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [], //untuk menampung data dari controller
                data: {}, //untuk crud
                url,
                apiUrl,
                editStatus: false,
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#example1').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET'
                        },
                        columns: columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(event, row, data) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm('Are you sure delete this data?')) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.url + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            // alert('Data succesfully delete');
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully delete!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            this.table.ajax.reload();
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var url = !this.editStatus ? this.url : this.url + '/' + id;
                    axios.post(url, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        _this.table.ajax.reload();

                        if (this.editStatus == false) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully submitted!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully update!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            }
        });

        // $('select[name=gender]').on('change', function() {
        //     gender = $('select[name=gender]').val();

        //     if (gender == 0) {
        //         controller.table.ajax.url(apiUrl).load();
        //     } else {
        //         controller.table.ajax.url(apiUrl + '?gender=' + gender).load();
        //     }
        // })
    </script>
@endsection
