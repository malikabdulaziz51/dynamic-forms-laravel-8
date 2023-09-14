@extends('layouts.admin.app')

@section('title', 'Tags')

@section('main')
@livewire('admin.tags')
@endsection


@push('scripts')
<script>
    window.addEventListener('hideTagsModal', function(e) {
            $('#tags_modal').modal('hide');
        });

        window.addEventListener('showTagsModal', function(e) {
            $('#tags_modal').modal('show');
        });

        $('#tags_modal').on('hidden.bs.modal', function (e) {
            Livewire.emit('resetModalForm');
        });

        window.addEventListener('deleteTag', function (e) {
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
                    window.livewire.emit('deleteTagAction', e.detail.id);
                }
            })
        })

</script>
@endpush
