<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function preOrder(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.menu_id' => 'required|exists:menus,id',
        'items.*.quantity' => 'required|integer|min:1',
        'order_date' => 'required|date|after_or_equal:today'
    ]);
    
    DB::beginTransaction();
    
    try {
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_date' => $request->order_date,
            'status' => 'pending',
            'total_amount' => 0
        ]);
        
        $total = 0;
        
        foreach ($request->items as $item) {
            $menu = Menu::find($item['menu_id']);
            
            // Cek kuota
            $remainingQuota = $menu->getRemainingQuota($request->order_date);
            if ($remainingQuota < $item['quantity']) {
                throw new \Exception("Kuota untuk {$menu->name} tidak mencukupi. Sisa: {$remainingQuota}");
            }
            
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
                'subtotal' => $menu->price * $item['quantity']
            ]);
            
            $total += $menu->price * $item['quantity'];
        }
        
        $order->update(['total_amount' => $total]);
        
        DB::commit();
        
        return redirect()->route('orders.show', $order)
            ->with('success', 'Pre-order berhasil dibuat');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $orders = Order::with('user')->latest()->paginate(10);
        } else {
            $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $query = Menu::where('is_available', true);
        if ($request->has('menu_id')) {
            $query->where('id', $request->menu_id);
        }
        $menus = $query->get()->map(function ($menu) use ($date) {
            $menu->remaining_quota = $menu->getRemainingQuota($date);
            return $menu;
        });
        return view('orders.create', compact('menus', 'date'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // redirect to preOrder for backwards compatibility
        return $this->preOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (! auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('items.menu');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        // admin can set any status
        if (auth()->user()->isAdmin()) {
            $request->validate(['status' => 'required|string']);
            $order->update(['status' => $request->status]);
            return redirect()->route('orders.show', $order)->with('success', 'Status order diperbarui');
        }

        // customer can only mark their own confirmed order as completed
        if ($order->user_id === auth()->id() && $order->status === 'confirmed') {
            $order->update(['status' => 'completed']);
            return redirect()->route('orders.show', $order)->with('success', 'Order ditandai selesai');
        }

        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        if (! auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order dibatalkan');
    }
}
