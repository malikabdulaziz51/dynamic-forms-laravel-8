@extends('layouts.admin.app')

@section('title', 'Tambah Berita')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('admin/library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/library/selectric/public/selectric.css') }}">
<style>
    #upload {
        opacity: 0;
    }

    #upload-label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
    }

    .image-area {
        border: 2px dashed rgba(255, 255, 255, 0.7);
        position: relative;
    }

    .image-area::before {
        content: 'Uploaded image result';
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.8rem;
        z-index: 1;
    }

    .image-area img {
        z-index: 2;
        position: relative;
    }
</style>

@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{url()->previous()}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Tambah Guru atau Staff</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Guru atau Staff</a></div>
                <div class="breadcrumb-item">Tambah Guru atau Staff</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <form action=" {{route('admin.store-teacher')}} " method="POST" id="addTeacherForm"
                        enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan nama guru / staff" type="text" class="form-control"
                                            name="teacher_name" id="teacher_nameID" value="{{old('teacher_name')}}"
                                            required autofocus>
                                        @error('teacher_name')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Posisi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control select2" id="position" name="teacher_position">
                                            <option value="1">Guru</option>
                                            <option value="2">Staff</option>
                                        </select>
                                        @error('teacher_position')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="input-group mb-3 px-2 py-2 bg-white shadow-sm">
                                            <input id="upload" type="file" onchange="readURL(this);"
                                                class="form-control border-0" name="photo">
                                            <label id="upload-label" for="upload"
                                                class="font-weight-light text-muted">Choose file</label>
                                            <div class="input-group-append">
                                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i
                                                        class="fa fa-cloud-upload mr-2 text-muted"></i><small
                                                        class="text-uppercase font-weight-bold text-muted">Choose
                                                        file</small></label>
                                            </div>
                                        </div>
                                        @error('photo')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                        <div class="image-area mt-2"><img id="imageResult" src="#" alt=""
                                                class="img-fluid rounded shadow-sm mx-auto d-block" width="180"></div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('admin/library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin/library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('admin/js/page/forms-advanced-forms.js') }}"></script>

<script>
    /*  ==========================================
    SHOW UPLOADED IMAGE
    * ========================================== */
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageResult')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function () {
        $('#upload').on('change', function () {
            readURL(input);
        });
    });

    /*  ==========================================
        SHOW UPLOADED IMAGE NAME
    * ========================================== */
    var input = document.getElementById( 'upload' );
    var infoArea = document.getElementById( 'upload-label' );

    input.addEventListener( 'change', showFileName );
    function showFileName( event ) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = 'File name: ' + fileName;
    }
</script>
@endpush