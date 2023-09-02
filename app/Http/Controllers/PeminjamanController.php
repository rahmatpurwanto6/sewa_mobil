<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mobils = Mobil::all();
        return view('peminjaman', compact('mobils'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function api()
    {
        $mobils = Peminjaman::select('tgl_mulai', 'tgl_selesai', 'users.name', 'mobils.merk', 'mobils.model', 'mobils.plat', 'mobils.tarif')
            ->join('users', 'users.id', '=', 'peminjamen.user_id')
            ->join('mobils', 'mobils.id', '=', 'peminjamen.mobil_id');
        $datatables = datatables()->of($mobils)
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
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'tarif' => 'required'
        ]);
        $merk = $request->merk;
        $tarif = Mobil::where('tarif', $merk);
        // Mobil::create($request->all());
        $p = new Peminjaman();
        $p->merk = $request->merk;
        $p->model = $request->model;
        $p->plat = $request->plat;
        $p->tgl_mulai = $request->tgl_mulai;
        $p->tgl_selesai = $request->tgl_selesai;
        $p->tarif = $request->tgl_mulai * $request->tgl_selesai * $tarif;
        $p->save();

        session()->flash('message', 'Data berhasil disimpan');
        return redirect()->route('peminjaman.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
