<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['umkm', 'plan', 'verifiedBy']);

        // Filter by status
        if ($request->status == 'pending') {
            $query->whereNull('verified_at');
        } elseif ($request->status == 'verified') {
            $query->whereNotNull('verified_at');
        } elseif ($request->status == 'expired') {
            $query->whereNotNull('expires_at')->where('expires_at', '<', now());
        }

        // SEARCH BY UMKM NAME OR EMAIL
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('umkm', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('plan', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $subscriptions = $query->latest()->paginate(15);

        // Stats
        $stats = [
            'total' => Subscription::count(),
            'pending' => Subscription::whereNull('verified_at')->count(),
            'verified' => Subscription::whereNotNull('verified_at')->count(),
            'revenue' => Subscription::whereNotNull('verified_at')->sum('total_amount')
        ];

        return view('pages.admin.subscriptions.index', compact('subscriptions', 'stats'))
            ->with('search', $request->search)
            ->with('status', $request->status);
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