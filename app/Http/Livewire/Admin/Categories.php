<?php

namespace App\Http\Livewire\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Berita;

use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    public $category_name;
    public $selected_category_id;
    public $updateCategoryMode = false;

    protected $listeners = ["resetModalForm", "deleteCategoryAction"];

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->category_name = null;
    }

    public function addCategory()
    {
        $this->validate([
            "category_name" => "required|unique:categories,category_name",
        ]);

        $category = new Category();
        $category->category_name = $this->category_name;
        $category->slug = Str::slug($this->category_name);
        $saved = $category->save();

        if ($saved) {
            $this->dispatchBrowserEvent("hideCategoriesModal");
            $this->category_name = null;
            session()->flash("successMessage", "Kategori berhasil ditambahkan");
        } else {
            session()->flash("errorMessage", "Terjadi Kesalahan");
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->selected_category_id = $category->id;
        $this->category_name = $category->category_name;
        $this->updateCategoryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showCategoriesModal");
    }

    public function updateCategory()
    {
        if ($this->selected_category_id) {
            $this->validate([
                "category_name" => "required|unique:categories,category_name",
            ]);

            $category = Category::findOrFail($this->selected_category_id);
            $update = $category->update([
                "category_name" => $this->category_name,
                "slug" => Str::slug($this->category_name),
            ]);

            if ($update) {
                $this->dispatchBrowserEvent("hideCategoriesModal");
                $this->category_name = null;
                session()->flash("successMessage", "Kategori berhasil diubah");
            } else {
                session()->flash("errorMessage", "Terjadi Kesalahan");
            }
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->dispatchBrowserEvent("deleteCategory", [
            "title" => "Apakah anda yakin ?",
            "html" =>
                "Anda ingin menghapus <b>" . $category->category_name . "</b>",
            "id" => $id,
        ]);
    }

    public function deleteCategoryAction($id)
    {
        $category = Category::where("id", $id)->first();
        $totalBerita = Berita::where("category_id", $category->id)
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
            $category->delete();
            session()->flash("successMessage", "Kategori berhasil di hapus");
        }
    }

    public function render()
    {
        return view("livewire.admin.categories", [
            "categories" => Category::orderby("ordering", "asc")->paginate(5),
        ]);
    }
}
