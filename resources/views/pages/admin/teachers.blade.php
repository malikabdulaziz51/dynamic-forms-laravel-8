@extends('layouts.admin.app')

@section('title', 'Guru dan Staff')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('admin/library/selectric/public/selectric.css') }}">
@endpush

@section('main')
@livewire('admin.teachers')

@endsection




@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('admin/library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('admin/js/page/features-posts.js') }}"></script>
<!-- Page Specific JS File -->

<script>
    window.addEventListener('deleteTeacher', function (e) {
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
                    window.livewire.emit('deleteTeacherAction', e.detail.id);
                }
            })
        })
</script>
@endpush