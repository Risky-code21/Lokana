<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = SubscriptionPlan::query();
        
        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $plans = $query->latest()->paginate(10);
        
        // Stats untuk cards
        $stats = [
            'total' => SubscriptionPlan::count(),
            'active' => SubscriptionPlan::count(), // bisa dimodifikasi kalo ada kolom is_active
            'total_transactions' => Subscription::count(),
            'revenue' => Subscription::whereNotNull('verified_at')->sum('total_amount')
        ];
        
        // Kalo pake withQueryString() biar search tetap kepake di pagination
        return view('pages.admin.subscription_plans.index', compact('plans', 'stats'))
            ->with('search', $request->search);
    }

    public function create()
    {
        return view('pages.admin.subscription_plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_in_days' => 'required|integer|min:1',
            'features' => 'required|array',
            'features.*' => 'string|max:255'
        ]);

        SubscriptionPlan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'duration_in_days' => $request->duration_in_days,
            'features' => json_encode($request->features)
        ]);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Paket langganan berhasil ditambahkan');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('pages.admin.subscription_plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_in_days' => 'required|integer|min:1',
            'features' => 'required|array',
            'features.*' => 'string|max:255'
        ]);

        $subscriptionPlan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'duration_in_days' => $request->duration_in_days,
            'features' => json_encode($request->features)
        ]);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Paket langganan berhasil diperbarui');
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->load(['subscriptions.umkm', 'subscriptions.verifiedBy']);
        $subscriptionPlan->subscriptions_count = $subscriptionPlan->subscriptions()->count();
        $subscriptionPlan->active_subscriptions_count = $subscriptionPlan->subscriptions()
            ->where('expires_at', '>', now())
            ->count();
        
        return view('pages.admin.subscription_plans.show', compact('subscriptionPlan'));
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        if ($subscriptionPlan->subscriptions()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus paket karena sudah digunakan oleh UMKM');
        }
        
        $subscriptionPlan->delete();
        
        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Paket langganan berhasil dihapus');
    }
}