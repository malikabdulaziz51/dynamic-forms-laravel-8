<div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kategori</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Kategori</h4>
                                <div class="card-header-action">
                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                        data-target="#categories_modal"><i class="fas fa-plus"></i> <span>Buat
                                            Kategori</span> </a>

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
                                                <th>Nama Kategori</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($categories as $category)
                                            <tr>
                                                <td> {{$loop->iteration}} </td>
                                                <td> {{$category->category_name}} </td>
                                                <td>
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <a href="#" wire:click.prevent="editCategory({{$category->id}})"
                                                            class="btn btn-sm btn-icon btn-primary"><i
                                                                class="far fa-edit"></i></a>

                                                        <a href="" class="btn btn-sm btn-icon btn-danger"
                                                            wire:click.prevent="deleteCategory({{$category->id}})"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>

                                            @empty
                                            <tr>
                                                <td colspan="3"> <span class="text-danger">Kategori tidak ditemukan
                                                        (kosong)</span></td>
                                            </tr>

                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        {{$categories->links()}}
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




    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="categories_modal"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="POST" @if($updateCategoryMode) wire:submit.prevent='updateCategory()'
                @else wire:submit.prevent='addCategory' @endif>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"> {{ $updateCategoryMode ? 'Update Kategori' : 'Tambah Kategori'}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($updateCategoryMode)
                    <input type="hidden" wire:model='selected_category_id'>
                    @endif
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama kategori"
                            name="category_name" wire:model='category_name'>
                        @error('category_name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{$updateCategoryMode ? 'Update' : 'Save'}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
