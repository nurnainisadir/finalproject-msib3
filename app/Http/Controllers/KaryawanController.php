<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //tampilkan seluruh data
        $karyawan=Karyawan::orderBy('idkaryawan', 'ASC')->get();
        return view('karyawan.index',compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('karyawan.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump(request()->file('foto')); die;
        $request->validate([
            'kode_karyawan' => 'required:karyawan|max:20',
            'nama_karyawan' => 'required:karyawan|max:50',
            'no_tlp' => 'required:karyawan|max:15',
            'gender'=> 'required|in:L,P',
            'alamat' => 'required:karyawan|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
      
        if(!empty($request->foto)){
            $fileName = 'foto-'.$request->kode_karyawan.'.'.$request->foto->extension();
            //$fileName = $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img'),$fileName);
        }
        else{
            $fileName = '';
        }
        //lakukan insert data dari request form
        DB::table('karyawan')->insert(
            [
                'kode_karyawan'=>$request->kode_karyawan,
                'nama_karyawan'=>$request->nama_karyawan,
                'no_tlp'=>$request->no_tlp,
                'gender'=>$request->gender,
                'alamat'=>$request->alamat,
                'foto'=>$fileName,
                'created_at'=>now(),
            ]);
       
        return redirect()->route('karyawan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Karyawan::where('idkaryawan',$id)->first();
        return view('karyawan.detail',compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Karyawan::where('idkaryawan',$id)->first();
        return view('karyawan.form_edit',compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_karyawan' => 'required:karyawan|max:20',
            'nama_karyawan' => 'required:karyawan|max:50',
            'no_tlp' => 'required:karyawan|max:15',
            'gender'=> 'required|in:L,P',
            'alamat' => 'required:karyawan|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        
        $row = DB::table('karyawan')->where('idkaryawan',$id)->first();

        if(!empty($request->foto)){
            if(!empty($row->foto)) unlink('img/'.$row->foto);
            $fileName = 'foto-'.$request->kode_karyawan.'.'.$request->foto->extension();
            //$fileName = $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img'),$fileName);
        }
        else{
            $fileName = $row->foto;
        }
         DB::table('karyawan')->where('idkaryawan',$id)->update(
            [
                'kode_karyawan' => $request->kode_karyawan,
                'nama_karyawan'=>$request->nama_karyawan,
                'no_tlp'=>$request->no_tlp,
                'alamat'=>$request->alamat,
                'gender'=>$request->gender,
                'foto'=>$fileName,
                'updated_at'=>now(),
            ]);
        return redirect()->route('karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Karyawan::where($id);
         Karyawan::where('idkaryawan',$id)->delete();
        return redirect()->route('karyawan.index');
    }

    
}