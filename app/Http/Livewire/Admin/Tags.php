<?php

namespace App\Http\Livewire\Admin;
use App\Models\Tag;
use Illuminate\Support\Str;

use Livewire\Component;
use Livewire\WithPagination;

class Tags extends Component
{
    public $nama;
    public $selected_tag_id;
    public $updateTagMode = false;

    protected $listeners = ["resetModalForm", "deleteTagAction"];

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->nama = null;
    }

    public function render()
    {
        return view("livewire.admin.tags", [
            "tags" => Tag::select("id", "nama", "slug")
                ->latest()
                ->paginate(5),
        ]);
    }

    public function addTag()
    {
        $validatedData = $this->validate(
            ["nama" => "required|unique:tag,nama"],
            [
                "nama.required" => ":attribute tag tidak boleh kosong.",
                "nama.unique" =>
                    ":attribute tag sudah ada, coba dengan :attribute lain.",
            ]
        );

        $saved = Tag::create([
            "nama" => $this->nama,
            "slug" => Str::slug($this->nama),
        ]);

        if ($saved) {
            $this->dispatchBrowserEvent("hideTagsModal");
            $this->nama = null;
            session()->flash("successMessage", "Tag berhasil ditambahkan");
        } else {
            session()->flash(
                "errorMessage",
                "Terjadi Kesalahan, Gagal menambah tag"
            );
        }
    }

    public function editTag($id)
    {
        $tag = Tag::findOrFail($id);
        $this->selected_tag_id = $tag->id;
        $this->nama = $tag->nama;
        $this->updateTagMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showTagsModal");
    }

    public function updateTag()
    {
        if ($this->selected_tag_id) {
            $validatedData = $this->validate(
                ["nama" => "required|unique:tag,nama"],
                [
                    "nama.required" => ":attribute tag tidak boleh kosong.",
                    "nama.unique" =>
                        ":attribute tag sudah ada, coba dengan :attribute lain.",
                ]
            );

            $tag = Tag::findOrFail($this->selected_tag_id);
            $update = $tag->update([
                "nama" => $this->nama,
                "slug" => Str::slug($this->nama),
            ]);

            if ($update) {
                $this->dispatchBrowserEvent("hideTagsModal");
                $this->nama = null;
                session()->flash("successMessage", "Tag berhasil diubah");
            } else {
                session()->flash(
                    "errorMessage",
                    "Terjadi Kesalahan, Gagal menambah tag"
                );
            }
        }
    }

    public function deleteTag($id)
    {
        $tag = Tag::findOrFail($id);
        $this->dispatchBrowserEvent("deleteTag", [
            "title" => "Apakah anda yakin ?",
            "html" => "Anda ingin menghapus <b>" . $tag->nama . "</b>",
            "id" => $id,
        ]);
    }

    public function deleteTagAction($id)
    {
        $tag = Tag::where("id", $id)->first();
        $totalBerita = Berita::where("tag_id", $tag->id)
            ->get()
            ->count();
        if ($totalBerita > 0) {
            session()->flash(
                "errorMessage",
                "Kategori tidak dapat dihapus karena memiliki " .
                    $totalBerita .
                    " Berita terkait dengan kategori"
            );
        } else {
            $tag->delete();
            session()->flash("successMessage", "Tag berhasil di hapus");
        }
    }
}
