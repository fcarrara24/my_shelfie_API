<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all();
        return response()->json(['message' => 'all players', 'data' => $players], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // not needed sice we are working
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlayerRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('image')) {
            $img_path = Storage::put('images', $request->image);
            $formData['preview'] = $img_path;
        }
        $formData['matches'] = 0;
        $formData['victories'] = 0;

        $player = Player::create($formData);
        return $player;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //not necessary yet
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //not needed
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, Player $player)
    {
        $data = $request->validated();
        if (array_key_exists('image', $data)) {
            // Check if we already have a profile image
            if ($account->images) {
                // Extract the relative path from the absolute URL
                $image_path = str_replace(asset('storage/'), '', $account->image);
                // Delete the old profile image using the relative path
                Storage::delete($image_path);
            }
            // Store the uploaded image in images directory
            $img_path = $data['image']->store('images', 'public');

            // Generate the absolute URL for the stored image
            $img_url = asset('storage/' . $img_path);

            // Update the 'image' field with the absolute URL
            $data['image'] = $img_url;
        }

        $player->update($data);

        return $player;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();
        return response()->json(['message' => 'Player deleted successfully'], 200);
    }
}
