<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\animal;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        return view('welcome', compact('animals', 'images_by_animal'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $species = Species::get();
        return view('animals.animal-create')->with('species', $species);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
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
        $animal->admin_id = '1';
        $animal->save();
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $filename, 'public');
        $imageModel = new Image([
            'filename' => $filename,
            'type' => $image->getClientMimeType(),
            'path' => $path,
        ]);
        $imageModel->imageable_type = get_class($animal); // Set the imageable_type to the class name of the morphable model
        $imageModel->imageable_id = $animal->id; // Set the imageable_id to the id of the morphable model
        $imageModel->save();


        $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
            $query->where('imageable_id', $animal->getKey());
        })->get();
        $images_by_animal[$animal->id] = $images;


        // Render the view with the images
        // Render the view with the animal, images, and species
        return view('animals.animal', compact('animal', 'images_by_animal'))->with('species', $animal->species);
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

        if (!$animal) {
            abort(404);
        }

        $animal->load('images');

        $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
            $query->where('imageable_id', $animal->getKey());
        })->get();

        $images_by_animal[$animal->id] = $images;

        // Render the view with the images and species
        return view('animals.animal', compact('animal', 'images_by_animal'));
    }



    // $animal = animal::where('$animals->id =1');


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        $species = Species::get();
        $animal->load('images');

        $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
            $query->where('imageable_id', $animal->getKey());
        })->get();

        //Returns the edit.blade.php page with an array of teams
        // $image = $animal->images->first();
        $images_by_animal[$animal->id] = $images;

        // return view('animal-edit', compact('animal', 'image'));
        //->with('animal', $animal);
        // return view('animals.animal-edit')->with('animal', $animal)->with('images_by_animal', $images_by_animal);
        return view('animals.animal-edit')->with('animal', $animal)->with('images', $images)->with('species', $species);
    }

    /**
     * Update the specified animal in storage.
     *     * @return \Illuminate\Http\Response

     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, animal $animal)
    {
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
            'admin_id' => '1',
        ]);

        Log::debug('Update method called for animal ID ' . $animal->id);


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
        return view('animals.animal', compact('animal', 'images_by_animal'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $animal = animal::findOrFail($id);
        $animal->delete();
        return redirect()->route('animal.index')
            ->with('success', 'animal has been deleted successfully!');
    }

    public function deleteImage(Animal $animal, Image $image)
    {
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
