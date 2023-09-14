<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Livewire\WithPagination;

class Gallery extends Component
{

    public $name;
    public $selected_gallery_id;
    public $updateGalleryMode = false;

    protected $listeners = ["resetModalForm", "deleteGalleryAction"];

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->name = null;
    }

    public function render()
    {
        return view('livewire.admin.gallery', [
            "galleries" => \App\Models\Gallery::select("id", "name")
                ->latest()
                ->paginate(5),
        ]);
    }

    public function addGallery()
    {
        $validatedData = $this->validate(
            ["name" => "required|unique:galleries,name"],
            [
                "name.required" => ":attribute gallery tidak boleh kosong.",
                "name.unique" =>
                ":attribute gallery sudah ada, coba dengan :attribute lain.",
            ]
        );

        if ($validatedData) {
            $saved =  \App\Models\Gallery::create([
                "name" => $this->name,
            ]);


            if ($saved) {
                $this->dispatchBrowserEvent("hideGalleryModal");
                $this->name = null;
                session()->flash("successMessage", "Galeri berhasil ditambahkan");
            } else {
                session()->flash(
                    "errorMessage",
                    "Terjadi Kesalahan, Gagal menambah galeri"
                );
            }
        }
    }

    public function editGallery($id)
    {
        $gallery =  \App\Models\Gallery::findOrFail($id);
        $this->selected_gallery_id = $gallery->id;
        $this->name = $gallery->name;


        $this->updateGalleryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showGalleryModal");
    }

    public function updateGallery()
    {
        if ($this->selected_gallery_id) {
            $validatedData = $this->validate(
                ["name" => "required|unique:galleries,name"],
                [
                    "name.required" => ":attribute galeri tidak boleh kosong.",
                    "name.unique" =>
                    ":attribute galeri sudah ada, coba dengan :attribute lain.",
                ]
            );

            $gallery = \App\Models\Gallery::findOrFail($this->selected_gallery_id);

            $galleryOldName = Str::slug($gallery->name);
            $directory = 'public/images/gallery/';
            $galleryNewName = Str::slug($this->name);
            Storage::rename($directory . $galleryOldName, $directory . $galleryNewName);

            $update = $gallery->update([
                "name" => $this->name,
            ]);

            if ($update) {

                $this->dispatchBrowserEvent("hideGalleryModal");
                $this->name = null;
                session()->flash("successMessage", "Galeri berhasil diubah");
            } else {
                session()->flash(
                    "errorMessage",
                    "Terjadi Kesalahan, Gagal menambah galeri"
                );
            }
        }
    }

    public function deleteGallery($id)
    {
        $gallery = \App\Models\Gallery::findOrFail($id);
        $this->dispatchBrowserEvent("deleteGallery", [
            "title" => "Apakah anda yakin ?",
            "html" => "Anda ingin menghapus <b>" . $gallery->name . "</b>",
            "id" => $id,
        ]);
    }

    public function deleteGalleryAction($id)
    {
        $gallery = \App\Models\Gallery::where("id", $id)->first();
        $media = \App\Models\Photo::where("id_gallery", $gallery->id)
            ->get()
            ->count();
        if ($media > 0) {
            session()->flash(
                "errorMessage",
                "Galeri tidak dapat dihapus karena memiliki " .
                    $media .
                    " Media di dalam galeri"
            );
        } else {
            $gallery->delete();
            session()->flash("successMessage", "Galeri berhasil di hapus");
        }
    }
}
