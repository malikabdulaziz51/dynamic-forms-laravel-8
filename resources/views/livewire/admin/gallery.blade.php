<div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Galeri</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Galeri</h4>
                                <div class="card-header-action">
                                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#gallery_modal"><i
                                            class="fas fa-plus"></i> <span>Buat
                                            Galeri</span> </a>

                                    {{-- <a href="#" class="btn btn-danger"><i class="fas fa-print"></i> Printout List
                                        Stock </a> --}}
                                </div>
                            </div>
                            <div class="card-body">
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

                                <div class="table-responsive">
                                    <table id="example" class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($galleries as $item)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td> <a href="{{route('admin.gallery-details', $item->id)}}">{{ $item->name }}</a>  </td>
                                                <td>
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <a href="#" wire:click.prevent="editGallery({{ $item->id }})"
                                                            class="btn btn-sm btn-icon btn-primary"><i
                                                                class="far fa-edit"></i></a>

                                                        <a href="" class="btn btn-sm btn-icon btn-danger"
                                                            wire:click.prevent="deleteGallery({{ $item->id }})"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>

                                            @empty
                                            <tr>
                                                <td colspan="3"> <span class="text-danger">data tidak ditemukan
                                                        (kosong)</span></td>
                                            </tr>

                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>

                                    </nav>
                                </div>

                                {{-- <div class="text-center pt-1 pb-1">
                                    <a href="#" class="btn btn-primary btn-lg btn-round">
                                        View All
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="gallery_modal"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="POST" @if($updateGalleryMode) wire:submit.prevent='updateGallery()' @else
                wire:submit.prevent='addGallery' @endif>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"> {{ $updateGalleryMode ? 'Update Galeri' : 'Tambah Galeri'}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($updateGalleryMode)
                    <input type="hidden" wire:model='selected_gallery_id'>
                    @endif
                    <div class="form-group">
                        <label>Nama Galeri</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama galeri" name="name"
                            wire:model='name'>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{$updateGalleryMode ? 'Update' : 'Save'}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
