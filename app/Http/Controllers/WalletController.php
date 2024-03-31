<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class WalletController extends Controller
{

    public function getUserWallets()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return response()->json([
            'wallets' => $wallets,
        ], 200);
    }

    public function CreateWallet(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string|max:255',
                'balance' => 'required',
            ]);

            $wallet = Wallet::where('type', $request->input('type'))->where('user_id', Auth::id())->first();

            if ($wallet != NULL) {
                return response()->json([
                    'message' => 'Wallet Already exciste',
                ], 401);
            }

            $wallet = Wallet::create([
                'id' => Str::uuid(),
                'type' => $request->input('type'),
                'user_id' =>  Auth::id(),
                'balance' => $request->input('balance')
            ]);

            return response()->json([
                'message' => 'Wallet Created Successfully',
                'wallet balance' => $wallet->balance,
                'uuid' =>  $this->getId($wallet->id)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function AddBalance(Request $request)
    {
        try {

            $request->validate([
                'type' => 'required|string|max:255',
                'balance' => 'required',
            ]);


            $wallet = Wallet::where('type', $request->input('type'))->where('user_id', Auth::id())->first();
            if ($wallet == NULL) {
                return response()->json([
                    'erreur' => 'Wallet Not Found!',
                ], 401);
            }

            $wallet->balance = $wallet->balance + $request->input('balance');
            $wallet->save();

            return response()->json([
                'message' => 'Balance Added!',
                'new wallet balance' => $wallet->balance,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
