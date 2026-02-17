<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['umkm', 'plan', 'verifiedBy'])
            ->latest()
            ->paginate(15);
            
        return view('pages.admin.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['umkm', 'plan', 'verifiedBy']);
        return view('pages.admin.subscriptions.show', compact('subscription'));
    }

    public function verify(Request $request, Subscription $subscription)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $startsAt = now();
        $expiresAt = $startsAt->copy()->addDays($subscription->plan->duration_in_days);

        $subscription->update([
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'admin_notes' => $request->admin_notes ?? 'Terverifikasi',
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt
        ]);

        return redirect()->route('admin.subscriptions.show', $subscription)
            ->with('success', 'Langganan berhasil diverifikasi');
    }

    public function destroy(Subscription $subscription)
    {
        if ($subscription->payment_proof) {
            \Storage::disk('public')->delete($subscription->payment_proof);
        }
        
        $subscription->delete();
        
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Data langganan berhasil dihapus');
    }
}