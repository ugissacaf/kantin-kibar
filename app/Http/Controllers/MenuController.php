<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // show all menus to admin, but regular users may also see listing
        $date = $request->get('date', now()->toDateString());
        $menus = Menu::latest()->paginate(10);

        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            // attach remaining quota for users
            $menus->getCollection()->transform(function ($menu) use ($date) {
                $menu->remaining_quota = $menu->getRemainingQuota($date);
                return $menu;
            });
        }

        return view('menus.index', compact('menus', 'date'));
    }

    public function available(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $menus = Menu::where('is_available', true)->get()->map(function ($menu) use ($date) {
            $menu->remaining_quota = $menu->getRemainingQuota($date);
            return $menu;
        });
        return view('menus.available', compact('menus', 'date'));
    }

    public function create()
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('menus.create');
    }

    public function store(MenuRequest $request)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('menus.edit', compact('menu'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
        $data = $request->validated();
        if ($request->hasFile('image')) {
            // remove old image if exists
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menus', 'public');
        }
        $menu->update($data);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy(Menu $menu)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus');
    }
}
