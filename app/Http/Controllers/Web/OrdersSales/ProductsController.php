<?php

namespace App\Http\Controllers\Web\OrdersSales;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\ProductsService;
use App\Models\Record;
use App\Models\Region;
use App\Models\ScheduleRecord;
use App\Models\SubCategory;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user =  auth()->user();
        $client = Client::where('id_user',$user->id)->first();
        $categories = Category::whereNull('id_client')->orWhere('id_client', $client->id)->get();        
        $sub_categories = SubCategory::all();

        $walletIds = Wallet::where('id_client', $client->id)->pluck('id'); // Extraer solo los IDs
        $registros = Record::whereNull('deleted_at')->with('category','wallet')->get();

        $ScheduleRecords = ScheduleRecord::with('record.wallet','record.category')->whereNull('deleted_at')->get();
        $companies = Company::where('id_client',$client->id)->get();
        $companiesIds = $companies->pluck('id');
        $productos = ProductsService::whereIn('id_company',$companiesIds)->get();
    
        return Inertia::render('Inventaries/Products/Index', [
            'products' => $productos,
            'companies' => $companies,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'registros' => $registros,
            'walletTypes' => WalletType::all(),
            'programRecords' => $ScheduleRecords,
            // 'wallets' => Wallet::where('id_client', $client->id)->get(),
            'wallets' => Wallet::where('id_client', $client->id)->with('records')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            ProductsService::Create([
                'id_company' => $request->input('id_company') ,
                'name'  => $request->input('name'),
                'description'  => $request->input('description'),
                'sale_price'  => $request->input('sale_price'),
                'purchase_price'  => $request->input('purchase_price'),
                'type' => $request->input('type'),
                'SKU' => $request->input('sku'),
                'height'  => $request->input('height'),
                'weight'  => $request->input('weight'),
                'width'  => $request->input('width'),
                'length'  => $request->input('length'),
            ]);
        } catch (\Throwable $th) {
            error_log($th);
        }
        $isModal = $request->input('isModal');
        if (!$isModal) {
           return to_route('inventarios')->with('title', 'Éxito')
                ->with('message', 'Producto creado exitosamente.')
                ->with('type', 'success');
                
        }
        return;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = ProductsService::find($id);
            $product->update([
                'id_company' => $request->input('id_company') ,
                'name'  => $request->input('name'),
                'description'  => $request->input('description'),
                'sale_price'  => $request->input('sale_price'),
                'purchase_price'  => $request->input('purchase_price'),
                'type' => $request->input('type'),
                'SKU' => $request->input('sku'),
                'height'  => $request->input('height'),
                'weight'  => $request->input('weight'),
                'width'  => $request->input('width'),
                'length'  => $request->input('length'),
            ]);
        } catch (\Throwable $th) {
            error_log($th);
        }
        $isModal = $request->input('isModal');
        if (!$isModal) {
           return to_route('inventarios')->with('title', 'Éxito')
                ->with('message', 'Producto actualizado exitosamente.')
                ->with('type', 'success');
                
        }
       return back()->with('title', 'Éxito')
                 ->with('message', 'Producto actualizado exitosamente.')
                 ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $product = ProductsService::findOrFail($id);
            // $orderDetails = $product->orderDetails ?? collect();
            // $firstOrderId = null;
            // foreach ($orderDetails as $detail) {
            //     $order = $detail->order;
            //     if ($order) {
            //         $firstOrderId = $firstOrderId ?? $order->id;
            //         $order->orderDeliveries()->delete();
            //         $order->delete();
            //     }
            //     $detail->delete();
            // }
            $product->delete();
            // if ($firstOrderId) {
            //     $record = Record::where('description', 'like', 'Abono pedido N' . $firstOrderId . '%')->first();
            //     if ($record) {
            //         $wallet = Wallet::find($record->id_wallet);
            //         if ($wallet) {
            //             // Ajustar monto según tipo de registro
            //             if ($record->type === 'income') {
            //                 $wallet->amount -= $record->amount;
            //             } else {
            //                 $wallet->amount += $record->amount;
            //             }
            //             $wallet->save();
            //         }
            //         ScheduleRecord::where('id_record', $record->id)->delete();
            //         $record->delete();
            //     }
            // }

            DB::commit();

            return to_route('products')
                ->with('title', 'Éxito')
                ->with('message', 'Producto eliminado exitosamente. NO se han eliminado los registros relacionados al producto')
                ->with('type', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('title', 'Error')
                ->with('message', 'Hubo un problema al eliminar el producto: ' . $e->getMessage())
                ->with('type', 'error');
        }
    }
}
