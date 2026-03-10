<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\UmkmProfile;
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
    
    // Hitung penggunaan plan
    foreach ($plans as $plan) {
        $plan->subscriptions_count = $plan->subscriptions()->count();
        $plan->umkm_usage_count = UmkmProfile::where('subscription_plan_id', $plan->id)->count();
    }
    
    // Stats untuk cards
    $stats = [
        'total' => SubscriptionPlan::count(),
        'active' => SubscriptionPlan::where('is_active', true)->count(),
        'total_transactions' => Subscription::count(),
        'revenue' => Subscription::whereNotNull('verified_at')->sum('total_amount')
    ];
    
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
    // Load subscriptions dengan relasi yang benar
    $subscriptionPlan->load(['subscriptions.umkm', 'subscriptions.verifiedBy']);
    
    // Hitung subscriptions
    $subscriptionPlan->subscriptions_count = $subscriptionPlan->subscriptions()->count();
    $subscriptionPlan->active_subscriptions_count = $subscriptionPlan->subscriptions()
        ->where('expires_at', '>', now())
        ->count();
    
    // Hitung penggunaan dari umkm_profiles langsung
    $subscriptionPlan->umkm_usage_count = UmkmProfile::where('subscription_plan_id', $subscriptionPlan->id)->count();
    
    return view('pages.admin.subscription_plans.show', compact('subscriptionPlan'));
}

public function destroy(SubscriptionPlan $subscriptionPlan)
{
    // Cek apakah plan digunakan oleh subscriptions
    if ($subscriptionPlan->subscriptions()->exists()) {
        return back()->with('error', 'Tidak dapat menghapus paket karena sudah digunakan di tabel subscriptions');
    }
    
    // Cek apakah plan digunakan oleh umkm_profiles
    if (UmkmProfile::where('subscription_plan_id', $subscriptionPlan->id)->exists()) {
        return back()->with('error', 'Tidak dapat menghapus paket karena sudah digunakan oleh UMKM');
    }
    
    $subscriptionPlan->delete();
    
    return redirect()->route('admin.subscription-plans.index')
        ->with('success', 'Paket langganan berhasil dihapus');
}
}