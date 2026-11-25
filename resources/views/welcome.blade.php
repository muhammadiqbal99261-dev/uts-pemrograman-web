@extends('masterlayout')

@section('title', 'UTS Pem Web')

@push('styles')
    <style>
        .biodata-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffff;
        }

        .add-biodata-card {
            min-height: 460px;
            cursor: pointer;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }

        .add-biodata-card:hover {
            border-color: #86efac;
            background-color: #f9fafb;
        }

        .btn-add-circle {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, #6ec46e 0%, #58b957 100%);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .add-biodata-card:hover .btn-add-circle,
        .btn-add-circle:hover {
            transform: scale(1.06);
            box-shadow: 0 6px 18px rgba(88, 185, 87, 0.35);
        }

        .biodata-photo {
            height: 295px;
            width: 100%;
            object-fit: cover;
            object-position: top center;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            {{-- Card Tambah Biodata --}}
            <div class="col">
                <div class="card h-100 biodata-card add-biodata-card" data-bs-toggle="modal"
                    data-bs-target="#tambahBiodataModal" role="button" tabindex="0" aria-label="Tambah Biodata">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <button type="button" class="btn-add-circle" aria-label="Tambah Biodata">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                viewBox="0 0 16 16" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card Daftar Biodata --}}
            @foreach ($biodatas as $biodata)
                <div class="col">
                    <div class="card h-100 biodata-card overflow-hidden">
                        <img src="{{ $biodata->fotoUrl() }}" class="card-img-top biodata-photo"
                            alt="{{ $biodata->nama }}">

                        <div class="card-body d-flex flex-column px-3 pt-3 pb-3">
                            <h5 class="card-title fw-bold mb-1" style="font-size: 1.05rem;">{{ $biodata->nama }}</h5>
                            <p class="card-text text-body-secondary small mb-0" style="line-height: 1.45;">
                                {{ $biodata->deskripsi }}
                            </p>
                        </div>

                        <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-3">
                            <div class="border-top pt-3 d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm btn-edit-biodata"
                                    data-bs-toggle="modal" data-bs-target="#editBiodataModal"
                                    data-url="{{ route('biodata.update', $biodata) }}"
                                    data-nama="{{ $biodata->nama }}"
                                    data-deskripsi="{{ $biodata->deskripsi }}"
                                    data-foto="{{ $biodata->fotoUrl() }}">
                                    Edit
                                </button>

                                <form action="{{ route('biodata.destroy', $biodata) }}" method="POST"
                                    data-confirm="Yakin ingin menghapus biodata {{ $biodata->nama }}?"
                                    onsubmit="return confirm(this.dataset.confirm);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Modal Tambah Biodata --}}
    <div class="modal fade" id="tambahBiodataModal" tabindex="-1" aria-labelledby="tambahBiodataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahBiodataModalLabel">Tambah Biodata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tambahNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="tambahNama" name="nama"
                                value="{{ old('nama') }}" placeholder="Contoh: iqbal" required>
                        </div>
                        <div class="mb-3">
                            <label for="tambahDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="tambahDeskripsi" name="deskripsi" rows="3"
                                placeholder="Contoh: 24010110190 merupakan master dari uts ini..." required>{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label for="tambahFoto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="tambahFoto" name="foto" accept="image/*">
                            <div class="form-text">Opsional. Format gambar maks. 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Biodata --}}
    <div class="modal fade" id="editBiodataModal" tabindex="-1" aria-labelledby="editBiodataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editBiodataForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBiodataModalLabel">Edit Biodata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <img id="editFotoPreview" src="" alt="Preview Foto"
                                class="rounded border" style="max-height: 150px; object-fit: cover;">
                        </div>
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-0">
                            <label for="editFoto" class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" class="form-control" id="editFoto" name="foto" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editModal = document.getElementById('editBiodataModal');
            if (!editModal) return;

            editModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                if (!button) return;

                document.getElementById('editBiodataForm').action = button.getAttribute('data-url') || '#';
                document.getElementById('editNama').value = button.getAttribute('data-nama') || '';
                document.getElementById('editDeskripsi').value = button.getAttribute('data-deskripsi') || '';
                document.getElementById('editFotoPreview').src = button.getAttribute('data-foto') || '';
                document.getElementById('editFoto').value = '';
            });
        });
    </script>
@endpush
