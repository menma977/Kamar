<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View|Response
   */
  public function index()
  {
    $locations = Location::all();

    $data = [
      'locations' => $locations
    ];

    return view('location.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param null $id
   * @return RedirectResponse
   * @throws ValidationException
   */
  public function store(Request $request, $id = null)
  {
    $isUpdate = false;
    if ($id) {
      $location = Location::find($id);
      if ($request->address) {
        $this->validate($request, [
          'address' => 'required|string'
        ]);
        $location->address = $request->address;
      }
      $location->save();
    } else {
      $isUpdate = true;
      $location = new Location();
      $this->validate($request, [
        'address' => 'required|string'
      ]);
      $location->address = $request->input('address');
      $location->save();
    }

    if ($isUpdate) {
      return redirect()->back()->withInput(["message" => "Location has been updated"]);
    }

    return redirect()->back()->withInput(["message" => "Location has been added"]);
  }

  /**
   * Display the specified resource.
   *
   * @param Location $location
   * @return Response
   */
  public function show(Location $location)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Location $location
   * @return Response
   */
  public function edit(Location $location)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Location $location
   * @return Response
   */
  public function update(Request $request, Location $location)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param $id
   * @return RedirectResponse
   */
  public function delete($id)
  {
    Location::destroy($id);

    return redirect()->back()->withInput(["message" => "Room has been deleted"]);
  }
}
