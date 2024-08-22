<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reserve;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('reserve')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $reserves = Reserve::all();
        return view('payments.create', compact('reserves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'amount' => 'required|numeric',
        ]);

        Payment::create($request->all());
        return redirect()->route('payments.index');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $reserves = Reserve::all();
        return view('payments.edit', compact('payment', 'reserves'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'amount' => 'required|numeric',
        ]);

        $payment->update($request->all());
        return redirect()->route('payments.index');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index');
    }
}
