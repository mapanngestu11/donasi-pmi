@extends('admin.layout')

@section('title', 'Laporan Donasi - Admin Donasi PMI')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color: #da1f1f !important;">Laporan Donasi</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #da1f1f !important;">Home</a>
            </li>
            <li class="breadcrumb-item" style="color: #da1f1f !important;">Donasi</li>
            <li class="breadcrumb-item active" aria-current="page" style="color: #da1f1f !important;">Laporan Donasi</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #f8f9fc !important; border-bottom: 1px solid #e3e6f0;">
                    <h6 class="m-0 font-weight-bold" style="color: #4e73df;">Data Donasi</h6>
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <select id="filterStatus" class="form-control form-control-sm"
                            style="max-width: 180px; font-size: 14px;">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="settlement">Sudah Pembayaran</option>
                        </select>
                        <a href="{{ route('admin.donasi.laporan.export') }}" class="btn btn-success btn-sm" id="btnExport"
                            title="Export Excel">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>

                <div class="table-responsive p-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                        <i class="bi bi-plus"></i> Tambah Data
                    </button>


                    {{-- button tambah --}}
                    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- Header Modal -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahDataModalLabel">Form Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Body Modal: Form -->
                                <div class="modal-body">
                                    <form id="formTambahData" action="{{ route('donasi.input_manual') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Donasi</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                placeholder="Masukkan nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="no_hp" class="form-label">No. HP</label>
                                                    <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                        placeholder="Masukkan no. HP" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Masukkan email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="program" class="form-label">Program</label>
                                            <input type="text" class="form-control" id="program" name="program"
                                                placeholder="Masukkan program donasi" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nominal" class="form-label">Nominal</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                placeholder="Masukkan nominal" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="keterangan_pesan" class="form-label">Keterangan Pesan</label>
                                            <textarea class="form-control" id="keterangan_pesan" name="keterangan_pesan"
                                                placeholder="Masukkan keterangan pesan"></textarea>
                                        </div>

                                    </form>
                                </div>

                                <!-- Footer Modal: Tombol Simpan -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" form="formTambahData" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- end --}}
                    <table class="table align-items-center table-flush table-hover dataTable" id="dataTableHover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Nominal</th>
                                <th>Keterangan Pesan</th>
                                <th>Bank</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan di-load via DataTables AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Donasi -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Donasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Nama:</strong>
                            <p id="detail-nama" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>No. HP:</strong>
                            <p id="detail-no_hp" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p id="detail-email" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Nominal:</strong>
                            <p id="detail-nominal" class="mb-0 text-primary font-weight-bold">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Bank:</strong>
                            <p id="detail-bank" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Status:</strong>
                            <p id="detail-status" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Order ID:</strong>
                            <p id="detail-order_id" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Transaction ID:</strong>
                            <p id="detail-transaction_id" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Program:</strong>
                            <p id="detail-program" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Tanggal:</strong>
                            <p id="detail-tanggal" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Transaction Time:</strong>
                            <p id="detail-transaction_time" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Settlement Time:</strong>
                            <p id="detail-settlement_time" class="mb-0">-</p>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Keterangan Pesan:</strong>
                            <p id="detail-keterangan_pesan" class="mb-0">-</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Pastikan Bootstrap 5 CSS & JS sudah disertakan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        let table;

        $(document).ready(function() {
            table = $('#dataTableHover').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('admin.donasi.laporan') }}",
                    type: 'GET',
                    data: function(d) {
                        d.status_filter = $('#filterStatus').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal',
                        orderable: false
                    },
                    {
                        data: 'keterangan_pesan',
                        name: 'keterangan_pesan'
                    },
                    {
                        data: 'bank',
                        name: 'bank'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        orderable: false
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                language: {
                    processing: "Memproses...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                responsive: true
            });

            // Filter status change
            $('#filterStatus').on('change', function() {
                table.ajax.reload();

                // Update export button URL with filter
                var statusFilter = $(this).val();
                var exportUrl = "{{ route('admin.donasi.laporan.export') }}";
                if (statusFilter) {
                    exportUrl += '?status=' + statusFilter;
                }
                $('#btnExport').attr('href', exportUrl);
            });
        });

        function showDetail(id) {
            $.ajax({
                url: '/admin/donasi/laporan/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        $('#detail-nama').text(data.nama);
                        $('#detail-no_hp').text(data.no_hp);
                        $('#detail-email').text(data.email);
                        $('#detail-nominal').text(data.nominal);
                        $('#detail-bank').text(data.bank);
                        $('#detail-status').html('<span class="badge badge-' + getStatusBadge(data.status) +
                            '">' + data.status.toUpperCase() + '</span>');
                        $('#detail-order_id').text(data.order_id);
                        $('#detail-transaction_id').text(data.transaction_id);
                        $('#detail-program').text(data.program);
                        $('#detail-tanggal').text(data.tanggal);
                        $('#detail-transaction_time').text(data.transaction_time);
                        $('#detail-settlement_time').text(data.settlement_time);
                        $('#detail-keterangan_pesan').text(data.keterangan_pesan);
                        $('#detailModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat detail donasi'
                    });
                }
            });
        }

        function getStatusBadge(status) {
            switch (status) {
                case 'settlement':
                    return 'success';
                case 'pending':
                    return 'warning';
                case 'expire':
                    return 'danger';
                case 'cancel':
                    return 'secondary';
                default:
                    return 'info';
            }
        }

        function deleteDonasi(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data donasi akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/donasi/laporan/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    table.ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Gagal menghapus data'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus data'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
