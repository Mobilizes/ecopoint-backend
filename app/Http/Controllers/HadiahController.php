<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use App\Models\Penukaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HadiahController extends Controller
{
    public function index(Request $request)
    {
        $query = Hadiah::query();

        $hadiahs = $request->filled('limit')
            ? $query->paginate($request->limit)
            : $query->get();

        $meta = $request->filled('limit') ? [
            'page' => $hadiahs->currentPage(),
            'per_page' => $hadiahs->perPage(),
            'max_page' => $hadiahs->lastPage(),
            'count' => $hadiahs->total(),
        ] : null;

        if ($hadiahs == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar hadiah kosong',
                'data' => (object) []
            ]);
        }

        $hadiahs = $meta !== null ? $hadiahs->items() : $hadiahs;

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $hadiahs
        ];

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response);
    }

    public function show(string $id)
    {
        $hadiah = Hadiah::find($id);

        if ($hadiah == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail hadiah tidak ditemukan',
                'data' => (object) [],
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail hadiah berhasil diambil',
            'data' => $hadiah
        ]);
    }

    public function search(Request $request)
    {
        $query = Hadiah::where('nama_hadiah', 'like', "%{$request["nama"]}%");

        $hadiahs = $request->filled('limit')
            ? $query->paginate($request->limit)
            : $query->get();

        $meta = $request->filled('limit') ? [
            'page' => $hadiahs->currentPage(),
            'per_page' => $hadiahs->perPage(),
            'max_page' => $hadiahs->lastPage(),
            'count' => $hadiahs->total(),
        ] : null;

        if ($hadiahs == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar hadiah kosong',
                'data' => (object) []
            ], 200);
        }

        $hadiahs = $meta !== null ? $hadiahs->items() : $hadiahs;

        $response = [
            'status' => 'success',
            'message' => 'Daftar hadiah berhasil diambil',
            'data' => $hadiahs
        ];

        if ($meta !== null) {
            $response['meta'] = $meta;
        }

        return response()->json($response);
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'address' => 'required|array|min:1',
            'address.alamat' => 'required|string',
            'address.nama_penerima' => 'required|string',
            'address.nomor_telepon' => 'required|string',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|uuid|exists:hadiahs,id',
            'cart.*.kuantitas' => 'required|integer',
        ]);

        $user = Auth::user();


        $hadiahIds = collect($request->cart)->pluck('id')->all();

        $hadiahModels = Hadiah::whereIn('id', $hadiahIds)->get()->keyBy('id');

        $hadiahs = [];
        $totalPoin = 0;

        foreach ($request->cart as $hadiahReq) {
            $hadiah = $hadiahModels[$hadiahReq['id']] ?? null;

            if (!$hadiah) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Hadiah tidak ditemukan!',
                    'data' => (object) [],
                ], 400);
            }

            $totalPoin += $hadiah->poin * $hadiahReq['kuantitas'];

            $hadiahs[] = [
                'model' => $hadiah,
                'kuantitas' => $hadiahReq['kuantitas'],
            ];
        }

        if ($user->poin < $totalPoin) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Total poin tidak mencukupi!',
                'data' => (object) [],
            ], 400);
        }

        $user->poin -= $totalPoin;
        $user->save();

        $penukaran = new Penukaran();
        $penukaran->user_id = $user->id;
        $penukaran->alamat = $request->address['alamat'];
        $penukaran->nama_penerima = $request->address['nama_penerima'];
        $penukaran->nomor_telepon = $request->address['nomor_telepon'];
        $penukaran->save();

        foreach ($hadiahs as $hadiahReq) {
            $hadiah = $hadiahReq['model'];

            $penukaran->hadiahs()->attach([
                $hadiah->id => ['kuantitas' => $hadiahReq['kuantitas']],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout berhasil',
            'data' => (object) [],
        ]);
    }
}
