<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;

class MejaController extends RoutingController
{
  public function index()
  {
    $mejas = Meja::all();
    return view('pages.admin.meja.index', compact('mejas'));
  }

  public function create()
  {
    return view('pages.admin.meja.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nomor_meja_222297' => 'nullable|string|max:50|unique:meja_222297,nomor_meja_222297',
      'kapasitas_222297'  => 'required|integer|min:1',
      'status_222297'     => 'required|string|max:50',
    ]);

    $data = $request->only(['nomor_meja_222297', 'kapasitas_222297', 'status_222297']);

    Meja::create($data);

    return redirect()->route('admin.meja.index')->with('success', 'Meja added successfully!');
  }

  public function show($id)
  {
    $meja = Meja::findOrFail($id);
    return view('pages.admin.meja.show', compact('meja'));
  }

  public function edit($id)
  {
    $meja = Meja::findOrFail($id);
    return view('pages.admin.meja.edit', compact('meja'));
  }

  public function update(Request $request, $id)
  {
    $meja = Meja::findOrFail($id);

    $request->validate([
      'kapasitas_222297' => 'required|integer|min:1',
      'status_222297'    => 'required|string|max:50',
    ]);

    $data = $request->only(['kapasitas_222297', 'status_222297']);

    $meja->update($data);

    return redirect()->route('admin.meja.index')->with('success', 'Meja updated successfully!');
  }

  public function destroy($id)
  {
    $meja = Meja::findOrFail($id);
    $meja->delete();

    return redirect()->route('admin.meja.index')->with('success', 'Meja deleted successfully!');
  }

  public function updateStatus(Request $request, $id)
  {
    try {
      $meja = Meja::findOrFail($id);

      $request->validate([
        'status_222297' => 'required|string|in:kosong,dipesan,digunakan',
      ]);

      $oldStatus = $meja->status_222297;
      $newStatus = $request->status_222297;

      $meja->update([
        'status_222297' => $newStatus
      ]);

      $statusLabels = [
        'kosong'    => 'Kosong',
        'dipesan'   => 'Dipesan',
        'digunakan' => 'Digunakan'
      ];

      $message = "Meja {$meja->nomor_meja_222297} status berubah dari {$statusLabels[$oldStatus]} ke {$statusLabels[$newStatus]}";

      return redirect()->route('admin.meja.index')->with('success', $message);
    } catch (\Exception $e) {
      return redirect()->route('admin.meja.index')->with('error', 'Gagal mengupdate status meja. Silakan coba lagi.');
    }
  }
}
