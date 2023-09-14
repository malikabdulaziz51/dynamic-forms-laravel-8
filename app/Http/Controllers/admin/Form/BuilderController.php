<?php

namespace App\Http\Controllers\admin\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Northwestern\SysDev\DynamicForms\DynamicFormsProvider;

class BuilderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Form PPDB";
        $data = \App\Models\FormBuilder::first();
        $definition = null;
        if ($data != null) {
            return $this->edit($data->id);
        }
        return view('pages.admin.form-ppdb', compact('title'))->with([
            'definition' => $definition
        ]);
    }

    public function create()
    {
        $title = "Form";
        return view('pages.admin.form-ppdb', compact("title"))->with([
            // can provide a previously-saved form definition here
            'definition' => null,
        ]);
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            "definition",

        ]);
        $validation = Validator::make($requestData, [
            'definition' => 'required|json'
        ]);

        // You can then save this to your DB, a file,
        // or whatever you're using for persistence.
        if ($validation->passes()) {
            $createForm = \App\Models\FormBuilder::create([
                "definition" => $request["definition"]
            ]);

            if ($createForm) {
                return redirect()
                    ->route("admin.ppdb.form_ppdb")
                    ->with([
                        "successMessage" => "Form Berhasil Dibuat",
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->with([
                        "errorMessage" => "Form Gagal Dibuat",
                    ]);
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation);
        }
    }

    public function edit($id)
    {
        $title = "Form PPDB";
        $data = \App\Models\FormBuilder::select($id)->select('definition')->pluck('definition');
        $definition = null;
        if ($data != null) {
            $definition = $data[0];
        }

        return view('pages.admin.edit-form-ppdb')->with([
            // can provide a previously-saved form definition here
            'definition' => $definition,
            'id' => $id,
            'title' => $title
        ]);
    }

    public function update(Request $request, $id)
    {
        $requestData = $request->only([
            "definition",

        ]);

        $validation = Validator::make($requestData, [
            'definition' => 'required|json'
        ]);

        // You can then save this to your DB, a file,
        // or whatever you're using for persistence.
        if ($validation->passes()) {

            $data = [
                "definition" => $request["definition"]
            ];

            $form = \App\Models\FormBuilder::find($id);
            $update = $form->update($data);
            if ($update) {
                return redirect()
                    ->route("admin.ppdb.form_ppdb")
                    ->with([
                        "successMessage" => "Berhasil Memperbarui Form",
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->with([
                        "errorMessage" => "Form Gagal Diperbarui",
                    ]);
            }
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validation);
        }
    }
}
