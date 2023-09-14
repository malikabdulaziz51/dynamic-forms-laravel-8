@extends('layouts.admin.app')

@section('title', 'Website Settings')

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
        content: 'Preview';
        color: #6777ef;
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
            <h1>Website Settings</h1>
        </div>
        <form action=" {{route('admin.information.createorupdate-setting')}} " method="POST"
            enctype="multipart/form-data" class="needs-validation" novalidate="">
            @csrf
            {{-- @method("PUT") --}}
            <div class="section-body">
                @if(session()->has('successMessage'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <strong>{{ session('successMessage') }}</strong>
                    </div>
                </div>
                @elseif(session()->has('errorMessage'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <strong>{{ session('errorMessage') }}</strong>
                    </div>
                </div>
                @endif
                <div class="card mb-2">
                    <div class="section-body">
                        <div class="card card-primary mb-3">
                            <div class="card-header">
                                <h4 class="section-title text-primary mb-0">Logo Website</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group row mx-auto">
                                        <div class="col-sm-12 col-md-8 mx-auto">
                                            <div class="input-group mb-3 px-2 py-2 bg-white shadow-sm">
                                                <input id="upload" type="file" onchange="readURL(this);"
                                                    class="form-control border-0" name="logo">
                                                <label id="upload-label" for="upload"
                                                    class="font-weight-light text-muted">Choose
                                                    file</label>
                                                <div class="input-group-append">
                                                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i
                                                            class="fa fa-cloud-upload mr-2 text-muted"></i><small
                                                            class="text-uppercase font-weight-bold text-muted">Choose
                                                            file</small></label>
                                                </div>
                                            </div>
                                            @error('logo')
                                            <span class="text-danger error-text">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="image-area mt-2"><img id="imageResult"
                                                    src="{{ asset('/storage/images/logos/'. $settings->logo) }}" alt=""
                                                    class="img-fluid rounded shadow-sm mx-auto d-block" width="120">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-body">
                        <div class="card card-primary mb-3">
                            <div class="card-header">
                                <h4 class="section-title text-primary mb-0">Informasi dan Sosial Media</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan alamat" type="text" class="form-control"
                                            name="address" id="addressID" value="{{ $settings->address }}" autofocus>
                                        @error('address')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan email" type="email" class="form-control"
                                            name="email" id="emailID" value="{{$settings->email}}" autofocus>
                                        @error('email')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Telepon
                                        1</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan Telepon 1" type="number" class="form-control"
                                            name="phone" id="phoneID" value="{{$settings->phone}}" autofocus>
                                        @error('phone')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Telepon
                                        2</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan Telepon 2" type="number" class="form-control"
                                            name="phone2" id="phone2ID" value="{{$settings->phone2}}" autofocus>
                                        @error('phone2')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                        class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Instagram</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan link instagram" type="text" class="form-control"
                                            name="instagram" id="instagramID" value="{{$settings->instagram}}"
                                            autofocus>
                                        @error('instagram')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Youtube</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input placeholder="Masukkan link youtube" type="text" class="form-control"
                                            name="youtube" id="youtubeID" value="{{$settings->youtube}}" autofocus>
                                        @error('youtube')
                                        <span class="text-danger error-text">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
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
    </section>
</div>
@endsection

@push('scripts')
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