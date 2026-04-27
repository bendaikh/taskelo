@extends('client.layouts.app')

@section('title', 'Payments - Client Portal')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Payment History</h2>
    </div>

    @if($payments->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
            </svg>
            <p class="text-lg text-gray-500">No payments yet</p>
            <p class="text-sm text-gray-400 mt-2">Your payment history will appear here</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $payment->date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->date->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->project->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($payment->type === 'cash') bg-green-100 text-green-800
                                    @elseif($payment->type === 'check') bg-blue-100 text-blue-800
                                    @elseif($payment->type === 'bank_transfer') bg-purple-100 text-purple-800
                                    @elseif($payment->type === 'credit_card') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $payment->type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-green-600">{{ $currency }}{{ number_format($payment->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ $payment->notes ?? '-' }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total Paid:</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">{{ $currency }}{{ number_format($payments->sum('amount'), 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection
