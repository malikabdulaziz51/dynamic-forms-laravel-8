@extends('layouts.admin.app')

@section('title', 'Tambah Berita')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.css" />
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $gallery->name }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Galeri</a></div>
                    <div class="breadcrumb-item">{{ $gallery->name }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Upload Gambar atau Video</h4>
                            </div>
                            <div class="card-body">
                                @if (session()->has('successMessage'))
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
                                <form action="{{ route('admin.gallery.upload', $gallery->id) }}" class="dropzone"
                                    id="my-dropzone">
                                    @csrf
                                </form>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-12" align="center">
                                        <a type="button" class="btn btn-primary" id="submit-all">Upload</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Uploaded Image</h4>
                            </div>
                            <div class="card-body">
                                <div class="gallery gallery-fw" data-item-height="100" id="uploaded_image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"
        integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.js"></script>

    <script type="text/javascript">
        let myDropzone = new Dropzone("#my-dropzone", {
            autoProcessQueue: false,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4",
            // uploadMultiple: true,
            parallelUploads: 100,
            maxFilesize: 5,
            // maxFiles: 100,
        });

        myDropzone.on("addedfile", file => {
            var submitButton = document.querySelector("#submit-all");
            submitButton.addEventListener('click', function() {
                myDropzone.processQueue();
            });
        });
        var checkError = myDropzone.on("error", function(file, message) {
            $('.errorMessage').html(message);
            this.removeFile(file);
        });
        myDropzone.on("complete", function() {
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                var _this = this;
                _this.removeAllFiles();
            }
            load_images();
        });


        load_images();

        function load_images() {
            $.ajax({
                url: "{{ route('admin.gallery.fetch', "$gallery->id") }}",
                success: function(data) {
                    $('#uploaded_image').html(data);
                }
            })
        }

        $(document).on('click', '.remove_image', function() {
            var name = $(this).attr('id');
            $.ajax({
                url: "{{ route('admin.gallery.delete', "$gallery->id") }}",
                data: {
                    name: name
                },
                success: function(data) {
                    load_images();
                }
            })
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endpush
