<div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Berita & Artikel</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Berita</h4>
                                <div class="card-header-action">
                                    <a href=" {{route('admin.add-berita')}} " class="btn btn-primary"><i
                                            class="fas fa-plus"></i> Buat
                                        Berita </a>
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
                                <div class="float-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search"
                                            wire:model='search'>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Tags</th>
                                            <th>Author</th>
                                            <th>Tgl Dibuat</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($berita as $item)
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->judul}}</td>
                                        <td>{{$item->kategori->category_name}}</td>
                                        <td>
                                            @foreach ($item->tag as $tag)
                                            <span class="badge badge-info">{{ $tag->nama }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-inline-block ml-1">{{$item->author->name}}</div>
                                        </td>
                                        <td>{{date('d-M-Y', strtotime($item->created_at))}}</td>
                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a href="{{route('admin.edit-berita', $item->id)}}"
                                                    class="btn btn-sm btn-icon btn-primary"><i
                                                        class="far fa-edit"></i></a>

                                                <a href="" class="btn btn-sm btn-icon btn-danger"
                                                    wire:click.prevent="deleteBerita({{$item->id}})"><i
                                                        class="far fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"> <span class="text-danger">Berita tidak ditemukan
                                                    (kosong)</span></td>
                                        </tr>
                                        @endforelse
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        {{$berita->links()}}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
