<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function getTransactions()
    {
        $user = Auth::user();

        if ($user->role_id === 1) {

            $transactions = Transaction::with('user')
                ->get();

            return response()->json([
                'transactions' => $transactions,
            ], 201);
        }

        $transactions = Transaction::where('sender', $user->id)
            ->orWhere('receiver', $user->id)
            ->with('user')
            ->get();

        if ($transactions === NULL) {
            return response()->json([
                'message' => 'No transactions to show'
            ], 401);
        }

        return response()->json([
            'transactions' => $transactions,
        ], 201);
    }

    public function sendBalance(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'type' => 'required|string',
            'amount' => 'required',
        ]);

        try {
            $receiver = User::where('fistname', $request->input('firstname'))
                ->where('lastname', $request->input('lastname'))
                ->first();

            if ($receiver === NULL) {
                return response()->json([
                    'message' => 'User Not Found!'
                ], 401);
            }

            $wallet = Wallet::where('user_id', $receiver->id)
                ->where('type', $request->input('type'))
                ->first();

            if ($wallet === NULL) {
                return response()->json([
                    'message' => 'Reciever does not have the same type of wallet!'
                ], 401);
            }


            $sender_id = Auth::id();

            $balance = Wallet::where('user_id', $sender_id)
                ->where('type', $request->input('type'))
                ->value('balance');

            if ($balance < $request->input('amount')) {
                return response()->json([
                    'message' => 'Insufficient Balance'
                ], 401);
            }

            Transaction::create([
                'sender' => $sender_id,
                'amount' => $request->input('amount'),
                'receiver' => $receiver->id
            ]);

            $senderBalance = $balance - $request->input('amount');

            Wallet::where('user_id', $sender_id)
                ->where('type', $request->input('type'))
                ->update(['balance' => $senderBalance]);

            $receiverBalance = $balance + $request->input('amount');

            Wallet::where('user_id', $receiver->id)
                ->where('type', $request->input('type'))
                ->update(['balance' => $receiverBalance]);

            return response()->json([
                'message' => 'Amount sent Successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
