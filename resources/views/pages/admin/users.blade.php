@extends('layouts.admin.app')

@section('title', 'Manajemen User')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('admin/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
@livewire('admin.user')

@endsection




@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('admin/library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('admin/js/page/features-posts.js') }}"></script>
<!-- Page Specific JS File -->

<script>
    window.addEventListener('hideUserModal', function(e) {
            $('#user_modal').modal('hide');
        });

        window.addEventListener('showUserModal', function(e) {
            $('#user_modal').modal('show');
        });

        $('#user_modal').on('hidden.bs.modal', function (e) {
            Livewire.emit('resetModalForm');
        });

    window.addEventListener('deleteUser', function (e) {
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
                    window.livewire.emit('deleteUserAction', e.detail.id);
                }
            })
        })
</script>
@endpush
