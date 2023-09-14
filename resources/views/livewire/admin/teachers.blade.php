<div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Guru dan Staff</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Guru & Staff</h4>
                                <div class="card-header-action">
                                    <a href=" {{route('admin.add-teacher')}} " class="btn btn-primary"><i
                                            class="fas fa-plus"></i> Tambah
                                        Guru / Staff</a>
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
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Foto</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($teachers as $item)
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{($item->position == 1) ? 'Guru' : (($item->position == 2) ? 'Staff' :
                                            "")}}</td>
                                        <td>
                                            <div class="image-area"><img id="imageResult"
                                                    src="/storage/images/teachers/photos/thumb_{{$item->photo}}" alt=""
                                                    class="img-fluid rounded shadow-sm d-block" style="padding: 5px"
                                                    width="90">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a href="{{route('admin.edit-teacher', $item->id)}}"
                                                    class="btn btn-sm btn-icon btn-primary"><i
                                                        class="far fa-edit"></i></a>

                                                <a href="" class="btn btn-sm btn-icon btn-danger"
                                                    wire:click.prevent="deleteTeacher({{$item->id}})"><i
                                                        class="far fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"> <span class="text-danger">Guru dan Staff tidak ditemukan
                                                    (kosong)</span></td>
                                        </tr>
                                        @endforelse
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        {{$teachers->links()}}
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