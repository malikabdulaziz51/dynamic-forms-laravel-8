<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Berita extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search = "";

    protected $listeners = ["deleteBeritaAction"];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // dd(\App\Models\Berita::search(trim($this->search)));
        return view("livewire.admin.berita", [
            "berita" => \App\Models\Berita::search(trim($this->search))
                ->orderby("created_at", "asc")
                ->paginate(3),
            "tags" => \App\Models\Tag::select("id", "nama")->get(),
            "title" => "Berita",
        ]);
    }

    public function deleteBerita($id)
    {
        $berita = \App\Models\Berita::findOrFail($id);
        $this->dispatchBrowserEvent("deleteBerita", [
            "title" => "Apakah anda yakin ?",
            "html" => "Anda ingin menghapus berita ini?",
            "id" => $id,
        ]);
    }

    public function deleteBeritaAction($id)
    {
        $berita = \App\Models\Berita::findOrFail($id);
        $path = "images/post_images/";
        $thumbnail = $berita->thumbnail;

        if (
            $thumbnail != null &&
            Storage::disk("public")->exists($path . $thumbnail)
        ) {
            //Delete thumb
            if (
                Storage::disk("public")->exists(
                    $path . "thumbnails/thumb_" . $thumbnail
                )
            ) {
                Storage::disk("public")->delete(
                    $path . "thumbnails/thumb_" . $thumbnail
                );
            }

            //Delete post featured image
            Storage::disk("public")->delete($path . $thumbnail);
        }

        $delete_berita = $berita->delete();

        if ($delete_berita) {
            session()->flash("successMessage", "Berita berhasil di hapus");
        } else {
            session()->flash("errorMessage", "Terjadi kesalahan");
        }
    }
}
