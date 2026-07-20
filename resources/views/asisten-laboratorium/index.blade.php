@extends('layout.app')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="section-title">Tim Laboratorium</h1>
        
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs mb-4" id="labTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeMenu === 'kepala' ? 'active' : '' }}" 
                        id="kepala-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#kepala" 
                        type="button" 
                        role="tab" 
                        aria-controls="kepala" 
                        aria-selected="{{ $activeMenu === 'kepala' ? 'true' : 'false' }}">
                    Kepala Laboratorium
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeMenu === 'dosen' ? 'active' : '' }}" 
                        id="dosen-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#dosen" 
                        type="button" 
                        role="tab" 
                        aria-controls="dosen" 
                        aria-selected="{{ $activeMenu === 'dosen' ? 'true' : 'false' }}">
                    Dosen Laboratorium
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ str_starts_with($activeMenu, 'asisten') ? 'active' : '' }}" 
                        id="asisten-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#asisten" 
                        type="button" 
                        role="tab" 
                        aria-controls="asisten" 
                        aria-selected="{{ str_starts_with($activeMenu, 'asisten') ? 'true' : 'false' }}">
                    Asisten Laboratorium
                </button>
            </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content" id="labTabsContent">
            <!-- Kepala Laboratorium Tab -->
            <div class="tab-pane fade {{ $activeMenu === 'kepala' ? 'show active' : '' }}" 
                 id="kepala" 
                 role="tabpanel" 
                 aria-labelledby="kepala-tab">
                @if(isset($kepala) && $kepala)
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="{{ $kepala->photo ? asset('storage/' . $kepala->photo) : asset('images/avatar-placeholder.png') }}" 
                                         class="img-fluid rounded-start" 
                                         alt="{{ $kepala->name }}" 
                                         style="height: 100%; object-fit: cover;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $kepala->name }}</h3>
                                        <p class="text-muted">{{ $kepala->position ?? 'Kepala Laboratorium' }}</p>
                                        <hr>
                                        <dl class="row">
                                            @if($kepala->nip)
                                            <dt class="col-sm-4">NIP</dt>
                                            <dd class="col-sm-8">{{ $kepala->nip }}</dd>
                                            @endif
                                            @if($kepala->expertise)
                                            <dt class="col-sm-4">Bidang Keahlian</dt>
                                            <dd class="col-sm-8">{{ $kepala->expertise }}</dd>
                                            @endif
                                        </dl>
                                        
                                        @if($kepala->bio)
                                        <div class="mt-3">
                                            <h6>Tentang:</h6>
                                            <div>{!! $kepala->bio !!}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info">Data kepala laboratorium belum tersedia.</div>
                @endif
            </div>
            
            <!-- Dosen Laboratorium Tab -->
            <div class="tab-pane fade {{ $activeMenu === 'dosen' ? 'show active' : '' }}" 
                 id="dosen" 
                 role="tabpanel" 
                 aria-labelledby="dosen-tab">
                @if(isset($dosen) && $dosen->count() > 0)
                <div class="row g-4">
                    @foreach($dosen as $d)
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ $d->photo ? asset('storage/' . $d->photo) : asset('images/avatar-placeholder.png') }}" 
                                         class="img-fluid rounded-start" 
                                         alt="{{ $d->name }}" 
                                         style="height: 100%; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $d->name }}</h5>
                                        <p class="text-muted">{{ $d->position ?? 'Dosen Laboratorium' }}</p>
                                        <hr>
                                        <dl class="row">
                                            @if($d->nip)
                                            <dt class="col-sm-4">NIP</dt>
                                            <dd class="col-sm-8">{{ $d->nip }}</dd>
                                            @endif
                                            @if($d->expertise)
                                            <dt class="col-sm-4">Bidang Keahlian</dt>
                                            <dd class="col-sm-8">{{ $d->expertise }}</dd>
                                            @endif
                                        </dl>
                                        
                                        @if($d->bio)
                                        <div class="mt-3">
                                            <h6>Tentang:</h6>
                                            <div>{!! $d->bio !!}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info">Data dosen laboratorium belum tersedia.</div>
                @endif
            </div>
            
            <!-- Asisten Laboratorium Tab -->
            <div class="tab-pane fade {{ str_starts_with($activeMenu, 'asisten') ? 'show active' : '' }}" 
                 id="asisten" 
                 role="tabpanel" 
                 aria-labelledby="asisten-tab">
                <!-- Angkatan Filter -->
                @if(isset($angkatanList) && $angkatanList->count() > 0)
                <div class="mb-4">
                    <div class="btn-group" role="group" aria-label="Filter Angkatan">
                        <a href="{{ route('asisten-laboratorium') }}" 
                           class="btn {{ is_null($angkatan) ? 'btn-primary' : 'btn-outline-primary' }}">
                            Semua
                        </a>
                        @foreach($angkatanList as $tahun)
                        <a href="{{ route('asisten.angkatan', ['angkatan' => $tahun]) }}" 
                           class="btn {{ isset($angkatan) && $angkatan == $tahun ? 'btn-primary' : 'btn-outline-primary' }}">
                            Angkatan {{ $tahun }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Asisten List -->
                @if(isset($asisten) && $asisten->count() > 0)
                <div class="row g-4">
                    @foreach($asisten as $a)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4 hover-shadow transition-all">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-user-graduate text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title fw-bold text-primary mb-0">{{ $a->name }}</h6>
                                        <small class="text-muted">Asisten LPSKE</small>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            @if($a->nim)
                                            <tr>
                                                <td class="text-muted" style="width: 30px;"><i class="fas fa-id-card"></i></td>
                                                <td class="text-muted small">NIM:</td>
                                                <td class="small">{{ $a->nim }}</td>
                                            </tr>
                                            @endif
                                            @if($a->angkatan)
                                            <tr>
                                                <td class="text-muted"><i class="fas fa-calendar-alt"></i></td>
                                                <td class="text-muted small">Angkatan:</td>
                                                <td class="small">{{ $a->angkatan }}</td>
                                            </tr>
                                            @endif
                                            @if($a->study_program)
                                            <tr>
                                                <td class="text-muted"><i class="fas fa-graduation-cap"></i></td>
                                                <td class="text-muted small">Program:</td>
                                                <td class="small">{{ $a->study_program }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info">Tidak ada data asisten yang tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Activate tab based on URL hash
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`[data-bs-target="${hash}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }
    });
</script>
@endpush
@endsection
