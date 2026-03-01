<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addnew(Request $request)
    {
        $request->validate([
            'colocation_id' => 'required',
            'name' => 'required|min:2|max:50',
            'color' => 'required|max:50',
            'icon' => 'required|max:50',
        ]);

        Categorie::create([
            'colocation_id' => $request->colocation_id,
            'name' => $request->name,
            'color' => $request->color,
            'icon' => $request->icon
        ]);

        return redirect()->route('home')->with('success', 'Create completed successfully!');;
    }

    public function delete(Request $request)
    {
        $request->validate([
            'catid' => 'required',
        ]);

        Categorie::where('id', $request->catid)->delete();

        return redirect()->route('home')->with('success', 'Delete completed successfully!');;
    }
}
