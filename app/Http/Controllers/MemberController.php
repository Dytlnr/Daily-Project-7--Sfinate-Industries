<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PointMember;
use App\Models\RiwayatPoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
        ]);

        Member::create($request->only(['nama', 'telepon', 'alamat']));

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Data member diperbarui');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return back()->with('success', 'Member berhasil dihapus');
    }


    public function formTukarPoin($id)
    {
        $member = Member::findOrFail($id);
        $totalPoin = PointMember::where('member_id', $id)->value('total_point') ?? 0;

        return view('members.tukar-poin', compact('member', 'totalPoin'));
    }

    public function tukarPoin(Request $request, $id)
    {
        $request->validate([
            'poin' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $member = Member::findOrFail($id);
        $poinTersedia = PointMember::where('member_id', $id)->value('total_point') ?? 0;

        if ($request->poin > $poinTersedia) {
            return back()->with('error', 'Poin tidak mencukupi.');
        }

        DB::beginTransaction();
        try {
            // Kurangi poin
            $point = PointMember::firstOrNew(['member_id' => $id]);
            $point->total_point -= $request->poin;
            $point->save();

            // Simpan riwayat
            RiwayatPoin::create([
                'member_id' => $id,
                'orderan_id' => null,
                'poin' => $request->poin,
                'tipe' => 'kurang',
                'keterangan' => $request->keterangan ?? 'Penukaran poin manual',
            ]);

            DB::commit();
            return redirect()->route('member.tukar.form', $id)->with('success', 'Poin berhasil ditukarkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menukar poin: ' . $e->getMessage());
        }
    }

    public function riwayatPoin($id)
    {
        $member = Member::findOrFail($id);
        $riwayat = RiwayatPoin::where('member_id', $id)->latest()->paginate(10);
        return view('members.riwayat-poin', compact('member', 'riwayat'));
    }
}
