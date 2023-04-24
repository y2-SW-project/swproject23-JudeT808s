<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
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
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');
        $animals = Animal::with('images')->with('species')->get();
        //Only fill array with an animal that has images
        $animals_with_images = $animals->filter(function ($animal) {
            return $animal->images->count() > 0;
        });
        //Instantiate array
        $images_by_animal = [];
        //Loops through all animals with images that are morphed to specific animal
        foreach ($animals_with_images as $animal) {
            $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
                $query->where('imageable_id', $animal->getKey());
            })->get();

            $images_by_animal[$animal->id] = $images;
        }

        return view('admin.welcome', compact('animals', 'images_by_animal'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $species = Species::get();
        return view('admin.animals.animal-create')->with('species', $species);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'description' => 'required',
            'species_id' => 'required',
        ]);
        $animal = new Animal();
        $animal->name = $request->input('name');
        $animal->age = $request->input('age');
        $animal->description = $request->input('description');
        $animal->species_id = $request->input('species_id');
        $animal->admin_id = $user->id;
        $animal->save();
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $filename, 'public');

        $animal->images()->create([
            'filename' => $filename,
            'type' => $image->getClientMimeType(),
            'path' => $path,
        ]);
        //Sets image to morph to Animal class 
        $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
            //saving the animal id as the imageable_id
            $query->where('imageable_id', $animal->getKey());
        })->get();

        $images_by_animal[$animal->id] = $images;
        //Redirects to show function passing the new created animal id
        return redirect()->route('admin.animals.show', ['animal' => $animal->id]);
    }



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
        // Show the view with the images and species
        return view('admin.animals.animal', compact('animal', 'images_by_animal', 'related'))->with('images', $images)->with('species', $species);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $species = Species::get();
        $animal->load('images');

        $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
            //saving the animal id as the imageable_id
            $query->where('imageable_id', $animal->getKey());
        })->get();

        $images_by_animal[$animal->id] = $images;


        return view('admin.animals.animal-edit')->with('animal', $animal)->with('images', $images)->with('species', $species);
    }

    /**
     * Update the specified animal in storage.
     *     * @return \Illuminate\Http\Response

     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'description' => 'required',
            'species_id' => 'required',
        ]);

        $animal->update([
            'name' => $request->name,
            'age' => $request->age,
            'species_id' => $request->species_id,
            'admin_id' => $user->id,
        ]);

        // Log::debug('Update method called for animal ID ' . $animal->id);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');

            $animal->images()->create([
                'filename' => $filename,
                'type' => $image->getClientMimeType(),
                'path' => $path,
                'imageable_id' => $animal->id,
                'imageable_type' => 'animal',
            ]);
        }

        $animals = Animal::get();
        $images_by_animal = Image::whereIn('animal_id', $animals->pluck('id'))->get()->groupBy('animal_id');
        return redirect()->route('admin.animals.show', ['animal' => $animal->id]);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $animal = animal::findOrFail($id);
        $animal->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'animal has been deleted successfully!');
    }

    public function deleteImage(Animal $animal, Image $image)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        // Check if the animal and image exist and are related
        if ($animal->images->contains($image)) {
            // Delete the image from storage
            Storage::disk('public')->delete($image->path);

            // Delete the image record from the database
            $image->delete();

            return response()->json(['message' => 'Image deleted successfully'], 200);
        }

        return response()->json(['error' => 'Image not found or not associated with the animal'], 404);
    }
}