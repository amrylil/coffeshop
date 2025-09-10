<?php
namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Inertia\Inertia;
use Inertia\Response;

class MejaController extends RoutingController
{
    /**
     * Display the main table management page.
     */
    public function index(): Response
    {
        $mejas = Meja::orderBy('nomor_meja')->get();

        // Prepare statistics to be sent as props
        $stats = [
            'total'     => $mejas->count(),
            'kosong'    => $mejas->where('status', 'kosong')->count(),
            'dipesan'   => $mejas->where('status', 'dipesan')->count(),
            'digunakan' => $mejas->where('status', 'digunakan')->count(),
        ];

        return Inertia::render('Admin/Meja', [
            'mejas' => $mejas,
            'stats' => $stats,
        ]);
    }

    /**
     * Store a new table from the modal form.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nomor_meja' => 'required|string|max:50|unique:meja,nomor_meja',
            'kapasitas'  => 'required|integer|min:1',
            'status'     => 'required|string|in:kosong,dipesan,digunakan',
        ]);

        Meja::create($validatedData);

        return redirect()->route('admin.meja.index')->with('success', 'Table added successfully!');
    }

    /**
     * Update an existing table from the modal form.
     */
    public function update(Request $request, Meja $meja): RedirectResponse
    {
        $validatedData = $request->validate([
            'nomor_meja' => 'required|string|max:50|unique:meja,nomor_meja,' . $meja->id,
            'kapasitas'  => 'required|integer|min:1',
            'status'     => 'required|string|in:kosong,dipesan,digunakan',
        ]);

        $meja->update($validatedData);

        return redirect()->route('admin.meja.index')->with('success', 'Table updated successfully!');
    }

    /**
     * Update the status of a single table directly from the card.
     */
    public function updateStatus(Request $request, Meja $meja): RedirectResponse
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:kosong,dipesan,digunakan',
        ]);

        $meja->update(['status' => $validatedData['status']]);

        return redirect()->back()->with('success', "Status for Table {$meja->nomor_meja} has been updated.");
    }

    public function show(Meja $meja): Response
    {

        return Inertia::render('Admin/Meja/Show', [
            'meja' => $meja,
        ]);
    }

    /**
     * Delete a table.
     */
    public function destroy(Meja $meja): RedirectResponse
    {
        if (in_array($meja->status, ['dipesan', 'digunakan'])) {
            return redirect()->back()->with('error', 'Cannot delete a table that is currently reserved or in use.');
        }

        $meja->delete();

        return redirect()->route('admin.meja.index')->with('success', 'Table deleted successfully!');
    }
}