@extends('layouts.admin.app')

@section('title', 'Galeri')

@section('main')
@livewire('admin.gallery')
@endsection


@push('scripts')
<script>
    window.addEventListener('hideGalleryModal', function(e) {
            $('#gallery_modal').modal('hide');
        });

        window.addEventListener('showGalleryModal', function(e) {
            $('#gallery_modal').modal('show');
        });

        $('#gallery_modal').on('hidden.bs.modal', function (e) {
            Livewire.emit('resetModalForm');
        });

        window.addEventListener('deleteGallery', function (e) {
            Swal.fire({
            title:e.detail.title,
            html:e.detail.html,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('deleteGalleryAction', e.detail.id);
                }
            })
        })

</script>
@endpush
