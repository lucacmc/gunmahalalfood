<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingSlot;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_slot = $request->sort_slot;
        $slots_queries = ShippingSlot::query();
        if ($request->sort_slot) {
            $slots_queries->where('name', 'like', "%$sort_slot%");
        }

        $slots = $slots_queries->orderBy('status', 'desc')->paginate(15);


        return view('backend.setup_configurations.slots.index', compact('slots', 'sort_slot'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slot = new ShippingSlot;

        $slot->name = $request->name;
        $slot->value = $request->value;
        $slot->position = $request->position;

        $slot->save();

        flash(translate('Shipping Slot has been inserted successfully'))->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $slot = ShippingSlot::findOrFail($id);
        return view('backend.setup_configurations.slots.edit', compact('slot'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slot = ShippingSlot::findOrFail($id);
        $slot->name = $request->name;
        $slot->value = $request->value;
        $slot->position = $request->position;

        $slot->save();

        flash(translate('Shipping Slot has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slot = ShippingSlot::findOrFail($id);
        ShippingSlot::destroy($id);

        flash(translate('Shipping Slot has been deleted successfully'))->success();
        return redirect()->route('slots.index');
    }

    public function updateStatus(Request $request)
    {
        $slot = ShippingSlot::findOrFail($request->id);
        $slot->status = $request->status;
        $slot->save();

        return 1;
    }
}
