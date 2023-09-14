<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Teachers extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search = "";

    protected $listeners = ["deleteTeacherAction"];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.teachers', [
            "teachers" => \App\Models\Teacher::search(trim($this->search))->paginate(5),
            "title" => "Guru dan Staff",
        ]);
    }

    public function deleteTeacher($id)
    {
        $teacher = \App\Models\Teacher::findOrFail($id);
        $this->dispatchBrowserEvent("deleteTeacher", [
            "title" => "Apakah anda yakin ?",
            "html" => "Anda ingin menghapus data ini?",
            "id" => $id,
        ]);
    }

    public function deleteTeacherAction($id)
    {
        $teacher = \App\Models\Teacher::findOrFail($id);
        $path = "images/teachers/";
        $photo = $teacher->photo;

        if (
            $photo != null &&
            Storage::disk("public")->exists($path . $photo)
        ) {
            //Delete thumb
            if (
                Storage::disk("public")->exists(
                    $path . "photos/thumb_" . $photo
                )
            ) {
                Storage::disk("public")->delete(
                    $path . "photos/thumb_" . $photo
                );
            }

            //Delete post featured image
            Storage::disk("public")->delete($path . $photo);
        }

        $delete_teacher = $teacher->delete();

        if ($delete_teacher) {
            session()->flash("successMessage", "Berita berhasil di hapus");
        } else {
            session()->flash("errorMessage", "Terjadi kesalahan");
        }
    }
}
