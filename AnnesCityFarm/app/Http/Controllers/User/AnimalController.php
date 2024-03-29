<?php

namespace App\Http\Controllers\User;

use App\Models\Image;
use App\Models\animal;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;
use Illuminate\Database\Eloquent\Relations\Relation;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animals = Animal::with('images')->with('species')->get();

        $animals_with_images = $animals->filter(function ($animal) {
            return $animal->images->count() > 0;
        });
        $images_by_animal = [];

        foreach ($animals_with_images as $animal) {
            $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
                $query->where('imageable_id', $animal->getKey());
            })->get();

            $images_by_animal[$animal->id] = $images;
        }

        return view('gallery', compact('animals', 'images_by_animal'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animal = Animal::with('species')->findOrFail($id); // Chain 'with' before 'findOrFail'
        $species = Species::get();
        $species_id = $animal->species_id;
        $animal_id = $animal->id;
        $related = Animal::where('species_id', $species_id)->where('id', '<>', $id)->take(3)->get();

        // Retrieve articles by category ID with eager loading
        $animal->load('images');

        $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
            $query->where('imageable_id', $animal->getKey());
        })->get();

        $images_by_animal[$animal->id] = $images;


        // Render the view with the images and species
        return view('user.animals.animal', compact('animal', 'images_by_animal', 'related'))->with('images', $images)->with('species', $species);
    }
    // public function search(Request $request)
    // {
    //     $search = $request['search'] ?? "";
    //     if ($search != "") {
    //         $animals = Animal::where('name', 'LIKE', "%$search")->get();
    //     } else {
    //         $animals = Animal::all();
    //     }
    //     $data = compact('animals', 'search');
    //     return view('search')->with($data);
    // }
}