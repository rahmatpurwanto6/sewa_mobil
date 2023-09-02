<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mobil');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function api()
    {
        $mobils = Mobil::all();
        $datatables = datatables()->of($mobils)
            ->addColumn('status', function ($mobils) {
                if ($mobils->status == 1) {
                    return 'Sedang disewa';
                } else {
                    return 'tersedia';
                }
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'merk' => 'required',
            'model' => 'required',
            'plat' => 'required',
            'tarif' => 'required',
        ]);

        // Mobil::create($request->all());
        $mobil = new Mobil();
        $mobil->merk = $request->merk;
        $mobil->model = $request->model;
        $mobil->plat = $request->plat;
        $mobil->tarif = $request->tarif;
        $mobil->status = 0;
        $mobil->save();

        session()->flash('message', 'Data berhasil disimpan');
        return redirect()->route('mobil.index');
        // return redirect('mobil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function show(Mobil $mobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function edit(Mobil $mobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'merk' => 'required',
            'model' => 'required',
            'plat' => 'required',
            'tarif' => 'required',
        ]);

        $mobil->update($request->all());

        session()->flash('message', 'Data berhasil diupdate');
        return redirect()->route('mobil.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        session()->flash('message', 'Data berhasil dihapus');
        return redirect()->route('mobil.index');
    }
}
