<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Transformers\FormTransformer;

class FormsController extends Controller
{
    public function index()
    {
        $data = Form::all();
        
        return json()->withCollection(
            $data,
            new FormTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->user()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            Form::findOrFail($id),
            new FormTransformer
        );
    }

    public function update(Request $request, $id)
    {
      $form = Form::findOrFail($id);

      return ($form->update($request->all()))
            ? json()->success('The form has been updated.')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);

        return ($form->delete())
            ? json()->success('The form has been deleted.')
            : json()->error('Failed to delete');
    }
}