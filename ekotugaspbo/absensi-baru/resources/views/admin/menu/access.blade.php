@extends('layouts.app')

@section('content')
{{-- 1. AMBIL DATA PERMISSION DARI DB --}}
@php
    $permissions = \App\Models\Permission::all();
@endphp

<div class="container-fluid px-4">
    <div class="row">
        {{-- SIDEBAR NAVIGASI (KOLOM KIRI) --}}
        <div class="col-md-3 mb-4">
            @include('layouts.sidebar')
        </div>

        {{-- KONTEN UTAMA (KOLOM KANAN) --}}
        <div class="col-md-9">
            
            {{-- WIDGET JAM --}}
            <div class="card border-0 shadow-sm mb-4 bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0" id="clock">00:00:00</h4>
                        <p class="mb-0 opacity-75" id="date-string">Memuat tanggal...</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-3 py-2 rounded-pill border border-light">Status: Online</span>
                    </div>
                </div>
            </div>

            {{-- TABEL ACCESS CONTROL --}}
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Menu Access User</h5>
                        <small class="text-muted">Atur hak akses menu untuk setiap role user</small>
                    </div>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th style="width: 25%;">MENU</th>
                                <th class="text-center">ADMINISTRATOR</th>
                                <th class="text-center">PETUGAS</th>
                                <th class="text-center">GURU</th>
                                <th class="text-center">SUB</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr class="border-bottom">
                                <td class="py-3">
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #ff4d94; font-size: 0.75rem;">
                                        {{ $menu['name'] }}
                                    </span>
                                </td>
                                
                                {{-- Switch Admin --}}
                                <td class="text-center">
                                    @php $pAdmin = $permissions->where('role', 'admin')->where('menu_name', $menu['slug'])->first(); @endphp
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input custom-switch switch-ajax" type="checkbox" 
                                               data-role="admin" data-menu="{{ $menu['slug'] }}" 
                                               {{ ($pAdmin && $pAdmin->is_accessible) ? 'checked' : '' }}>
                                    </div>
                                </td>

                                {{-- Switch Petugas --}}
                                <td class="text-center">
                                    @php $pPetugas = $permissions->where('role', 'petugas')->where('menu_name', $menu['slug'])->first(); @endphp
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input custom-switch switch-ajax" type="checkbox" 
                                               data-role="petugas" data-menu="{{ $menu['slug'] }}" 
                                               {{ ($pPetugas && $pPetugas->is_accessible) ? 'checked' : '' }}>
                                    </div>
                                </td>

                                {{-- Switch Guru --}}
                                <td class="text-center">
                                    @php $pGuru = $permissions->where('role', 'guru')->where('menu_name', $menu['slug'])->first(); @endphp
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input custom-switch switch-ajax" type="checkbox" 
                                               data-role="guru" data-menu="{{ $menu['slug'] }}" 
                                               {{ ($pGuru && $pGuru->is_accessible) ? 'checked' : '' }}>
                                    </div>
                                </td>

                                {{-- Tombol Sub Menu --}}
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm btn-sub-menu" 
                                            style="background-color: #8c33ff; border: none; font-size: 0.7rem;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#subMenuModal"
                                            data-id="{{ $menu['id'] ?? 1 }}" 
                                            data-name="{{ $menu['name'] }}">
                                        <i class="bi bi-sliders me-1"></i> SUB
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SUB MENU --}}
<div class="modal fade" id="subMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header border-0 pt-4 px-4 bg-light">
                <h5 class="fw-bold mb-0">Sub Menu Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th>Menu</th>
                                <th class="text-center">Administrator</th>
                                <th class="text-center">Petugas</th>
                                <th class="text-center">Guru</th>
                            </tr>
                        </thead>
                        <tbody id="sub-menu-list">
                            {{-- Data otomatis terisi via JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Real-time Clock
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            $('#clock').text(now.toLocaleTimeString('id-ID'));
            $('#date-string').text(now.toLocaleDateString('id-ID', options));
        }
        setInterval(updateTime, 1000);
        updateTime();

        // AJAX Switch Toggle
        $('.switch-ajax').on('change', function() {
            let role = $(this).data('role');
            let menu = $(this).data('menu');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('permission.update') }}",
                method: "POST",
                data: { 
                    _token: "{{ csrf_token() }}", 
                    role: role, 
                    menu: menu, 
                    status: status 
                },
                success: function(response) {
                    Swal.mixin({ 
                        toast: true, 
                        position: 'top-end', 
                        showConfirmButton: false, 
                        timer: 2000, 
                        timerProgressBar: true 
                    }).fire({ 
                        icon: 'success', 
                        title: 'Akses berhasil diperbarui' 
                    });
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Gagal memperbarui data' });
                }
            });
        });

        // Trigger Sub Menu Modal
        $('.btn-sub-menu').on('click', function() {
            let menuName = $(this).data('name');
            $('.modal-header h5').text('Sub Menu Access - ' + menuName);
            $('#sub-menu-list').html('<tr><td colspan="4" class="text-center py-4 opacity-50">Loading sub-menu...</td></tr>');

            // Simulasi loading data
            setTimeout(() => {
                let mockupRows = `
                    <tr class="border-bottom">
                        <td class="py-3 text-muted">View Details</td>
                        <td class="text-center"><div class="form-check form-switch d-inline-block"><input class="form-check-input custom-switch" type="checkbox" checked></div></td>
                        <td class="text-center"><div class="form-check form-switch d-inline-block"><input class="form-check-input custom-switch" type="checkbox"></div></td>
                        <td class="text-center"><div class="form-check form-switch d-inline-block"><input class="form-check-input custom-switch" type="checkbox"></div></td>
                    </tr>
                    <tr>
                        <td class="py-3 text-muted">Export Data</td>
                        <td class="text-center"><div class="form-check form-switch d-inline-block"><input class="form-check-input custom-switch" type="checkbox" checked></div></td>
                        <td class="text-center"><div class="form-check form-switch d-inline-block"><input class="form-check-input custom-switch" type="checkbox"></div></td>
                        <td class="text-center"><div class="form-check form-switch d-inline-block"><input class="form-check-input custom-switch" type="checkbox"></div></td>
                    </tr>
                `;
                $('#sub-menu-list').html(mockupRows);
            }, 400);
        });
    });
</script>

<style>
    .custom-switch { 
        width: 2.4rem !important; 
        height: 1.2rem !important; 
        cursor: pointer; 
    }
    .table th { font-weight: 600; letter-spacing: 0.5px; }
</style>
@endsection