<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function getItems()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function postItem(Request $request) {
        $validated = $request->validate([
            'itemName' => 'required|string',
            'itemDescription' => 'required|string|max:255|min:3',
            'itemPrice' => 'required|numeric|min:0',
        ]);

        $existingItem = Item::where('itemName', $validated['itemName'])->first();

        if ($existingItem) {
            return response()->json([
                'message' => 'Item already exists.',
            ], 409);
        }

        $validated['itemPrice'] = $validated['itemPrice'] ?? 0.00;

        $item = Item::create($validated);
    
        return response()->json([
            'message' => 'Item added successfully',
            'expense' => $item,
        ], 201);
    }

    public function patchItem(Request $request, $_id) {
        $validated = $request->validate([
            'itemName' => 'sometimes|string',
            'itemDescription' => 'sometimes|string|max:255|min:3',
            'itemPrice' => 'sometimes|numeric|min:0',
        ]);

        $itemId = trim($_id);

        $item = Item::where('_id', $itemId)->first();
    
        if (!$item) {
            return response()->json(['message' => 'Item not Found.'], 404);
        }

        if (!empty($validated['_id']) && $validated['_id'] !== $_id) {
            $duplicate = Item::where('_id', $validated['_id'])
                                ->exists();

            if ($duplicate) {
                return response()->json(['message' => 'Item Name Already Exists.'], 409);
            }
        }

        $item->fill($validated);
        $item->save();
    
        return response()->json([
            'message' => 'Item updated successfully.',
            'expense' => $item,
        ], 200);
    }

    public function deleteItem(Request $request, $_id) {
        $itemId = trim($_id);

        $item = Item::where('_id', $itemId)->first();
    
        if (!$itemId) {
            return response()->json(['message' => 'Item not Found.'], 404);
        }
    
        $item->delete();
    
        return response()->json(['message' => 'Item deleted successfully.'], 200);
    }    
}
