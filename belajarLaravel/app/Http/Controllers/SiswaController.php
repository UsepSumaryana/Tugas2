<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //
    public function index(){
    	$data['result'] = \App\Siswa::all();
    	return view('siswa/index')->with($data);
    }

    public function create()
    {
    	return view("siswa/form");
    }

    public function store(Request $request)
    {
    	$rules = [
    	'nis' 					=> 'required|unique:t_siswa',
    	'nama_lengkap' 			=> 'required|max:100',
    	'jenis_kelamin' 		=> 'required',
    	'no_telp' 				=> 'required',
    	'id_kelas' 				=> 'required|exists:t_kelas',
    	'foto'  				=> 'required|mimes:jpeg,png|max:512'
    	];
    		$this->validate($request, $rules);
    		$input = $request->all();

    		if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
    			# code...
    			$filename = $input['nis']. "." .$request->file('foto')->getClientOriginalExtension();
    			$request->file('foto')->storeAs('', $filename);
    			$input['foto'] = $filename;
    		}

    		$Status = \App\Siswa::create($input);

    		if ($Status) return redirect('siswa')->with('success', 'Data berhasil ditambahkan');
    		else return redirect('siswa')->with('error', 'Data gagal ditambahkan');
    }

	public function edit($id)
	{
		$data['result'] = \App\Siswa::where('nis', $id)->first();
		return view('siswa/form')->with($data);
	}

	public function update(Request $request, $id)
	{
		$rules = [
    	'nis' 				=> 'required|unique:t_siswa',
    	'nama_lengkap' 				=> 'required|max:100',
    	'jenis_kelamin' 			=> 'required',
    	'no_telp' 					=> 'required',
    	'id_kelas' 					=> 'required|exist:t_kelas',
    	'foto'  				=> 'required|mimes:jpeg,png|max:512'
    	];
    		// $this->validate($request, $rules);
    		$input = $request->all();

    		if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
    			# code...
    			$filename = $input['nis'] . "." . $request->file('foto')->getClientOriginalExtension();
    			$request->file('foto')->storeAs('', $filename);
    			$input['foto'] = $filename;
    		}

			$result = \App\Siswa::where('nis', $id)->first();
    		$Status = $result->update($input);
    		
    		if ($Status) return redirect('siswa')->with('success', 'Data berhasil diubah');
    		else return redirect('siswa')->with('error', 'Data gagal diubah');
	}

	public function destroy(Request $request, $id)
    {
         $result = \App\Siswa::where('nis', $id)->first();
        $status = $result->delete();
        if ($status) return redirect('siswa') ->with('success','Data berhasil dihapus');
        else return redirect('siswa')->with('error','data gagal di hapus');
    }
}
