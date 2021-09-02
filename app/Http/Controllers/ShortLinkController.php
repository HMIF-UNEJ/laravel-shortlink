<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            return datatables()->of(ShortLink::query())
            ->editColumn('edit', function ($data) {
                $mystring = '<a href="'.route("hapus.link", $data->id).'" onclick="return confirm(`Apakah anda ingin menghapus ?`)" class="btn btn-danger">Hapus</a>';
                return $mystring;
            })
            ->editColumn('short', function ($data) {
                $mystring = '<a href="'.route('shorten.link', $data->code).'">'.route('shorten.link', $data->code).'</a>';
                return $mystring;
            })
            ->rawColumns(['edit','short'])
            ->make(true);
        }
        return view('admin.link.index');
    }

    public function store(Request $request)
    {
        $request->validate([
           'link' => 'required|url'
        ]);

        if (!$request->filled('code')) {
            ShortLink::create([
                'link' => $request->link,
                'code' => Str::random(6),
            ]);
        } else {
            ShortLink::create([
                'link' => $request->link,
                'code' => $request->code,
            ]);
        }
        
  
        return redirect()->route('dashboard.index');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();
        return redirect($find->link);
    }

    public function destroy($id)
    {
        $participant = ShortLink::find($id);
        if (!$participant) {
            return redirect()->back();
        }
        
        $participant->delete();
        return redirect()->route('dashboard.index');
    }


}
