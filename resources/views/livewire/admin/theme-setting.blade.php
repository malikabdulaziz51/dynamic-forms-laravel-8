<div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tema Website</h1>
            </div>
            <div class="section-body">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="text-primary mb-0">Tema Website</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.theme.updateTheme') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">

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
                                    <div class="form-group">
                                        <select name="theme_id" required="" class="form-control">
                                            @foreach ($themes as $item)
                                            <option value="{{ $item->id }}" @if ($activeTheme->id === $item->id)
                                                selected
                                                @endif>
                                                {{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Pilih Tema</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>