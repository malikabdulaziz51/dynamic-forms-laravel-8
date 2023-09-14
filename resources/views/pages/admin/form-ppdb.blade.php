@extends('layouts.admin.app')

@section('title', 'Form PPDB')

@push('style')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form PPDB</h1>
            </div>

            <div class="section-body">
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
                <div class="row">
                    <div class="col-12">
                        <form method="post" action="{{ route('admin.ppdb.store') }}">
                            @csrf
                            <input type="hidden" name="definition" id="definition" value="">

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" style="float: right;" type="submit">Simpan
                                        Form</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <!-- This becomes the builder. -->
            <div id="formio-builder"></div>
        </section>
    </div>

    <!-- The options can be customized to control the available elements. -->
    <script lang="text/javascript">
        window.onload = function() {
            const defaultForm = {
                /* There are two styles of form builder [wizard, form]. Wizard is the name for multi-page layouts.
                 * We are using wizard layout for all surveys so the selection option is no longer included. */
                display: 'wizard',

            };
            new Formio.builder(
                document.getElementById('formio-builder'), defaultForm,
                @if (isset($definition))
                    {!! $definition !!}
                @else
                    {}
                @endif , {} // these are the opts you can customize
            ).then(function(builder) {
                // Exports the JSON representation of the dynamic form to that form we defined above
                document.getElementById('definition').value = JSON.stringify(builder.schema);

                builder.on('change', function(e) {
                    // On change, update the above form w/ the latest dynamic form JSON
                    document.getElementById('definition').value = JSON.stringify(builder.schema);
                })
            });;
        };
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endpush
