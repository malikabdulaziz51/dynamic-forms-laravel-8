<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function create()
    {
        $getdata = json_encode(\App\Models\FormBuilder::select('definition')->pluck('definition'));
        $definition = json_decode($getdata)[0];


        return view('pages.site.form', compact('definition'))->with([ // get some definition JSON
            'data' => '{}', // you can edit a form by providing the old data
        ]);
    }

    public function store(Request $request)
    {
        // if ($request->get('state') === 'draft') {
        //     // Someone added a 'Save Draft' button to the form, and the user clicked that.
        //     // You can do some different behaviours if you'd like.
        // }
        $getdata = json_encode(\App\Models\FormBuilder::select('definition')->pluck('definition'));
        $definition = json_decode($getdata)[0];

        $data = $request->validateDynamicForm(
            $definition, // get some definition JSON
            $request->get('submissionValues'),
            null
        );

        // Here is your validated form data
        \App\Models\Form::create([
            "submissionValues" => $request["submissionValues"]
        ]);
    }


}
