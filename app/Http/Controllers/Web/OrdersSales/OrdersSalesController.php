<?php

namespace App\Http\Controllers\Web\OrdersSales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\SendMailController;
use App\Models\Client;
use App\Models\Commune;
use App\Models\Company;
use App\Models\Consumer;
use App\Models\Order;
use App\Models\OrderDeliveries;
use App\Models\OrderDetail;
use App\Models\OrderState;
use App\Models\ProductsService;
use App\Models\Province;
use App\Models\Record;
use App\Models\Region;
use App\Models\Wallet;
use App\Services\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrdersSalesController extends Controller
{
    protected $mailService;

    public function __construct(SendMail $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $wallets = Wallet::where('id_client', $client->id)->get();
            $companies = Company::where('id_client', $client->id)->with(['workers', 'projects.state','orders.orderDeliveries','orders.orderDetails.product','orders.state','orders.consumer'])->get();
            $companiesIds = $companies->pluck('id');
            $consumers = Consumer::whereIn('id_company',$companiesIds)->get();
            $productServices = ProductsService::whereIn('id_company',$companiesIds)->get();
        } else if($user->hasRole('SuperAdmin')){
            $companies = Company::with(['workers', 'projects'])->get();
        }

        return Inertia::render('OrdersSales/Index', [
            'companies' => $companies,
            'consumers' => $consumers,
            'productServices' => $productServices,
            'user' => $user,
            'regions' => Region::with('province.comuna')->get(),
            'provinces' => Province::all(),
            'comunes' => Commune::all(),
            'wallets' => $wallets,
            'OrderStates' => OrderState::all(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $productsIds = $request->input('products');
        $productsSelected = ProductsService::whereIn('id', $productsIds)->get();
        $total = $request->input('total_amount') - $request->input('discounts');
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'client_id' => 'required| ',
                'id_company' => 'required|integer',
                'total_amount' => 'required|integer',
                'discounts' => '',
                'amount_paid' => 'required',
                
            ]);
            //Orden General del pedido
            $order = Order::Create([
                'id_consumer' => $request->input('client_id'),
                'id_shop_order' => $request->input('id_company') ,
                'sale_price' =>  $request->input('total_amount'), //valor venta
                'discounts' => $request->input('discounts') , //descuento
                'total_amount' => $total , //valor total valor venta menos descuentos
                'amount_paid' => $request->input('amount_paid'), //abono
                'payment_date' => NULL ,// fecha del pago final
                'note' => $request->input('notes'),//notas del pedido
                'id_invoice' => Null , //id factura boleta
                'order_date' => date('Y-m-d H:i:s')  , 
                'id_state' => $request->input('id_state'),
            ]);
            if ($request->input('type') == 'order/delivery') {
                //orden del Envio
                $orderDeliveries = OrderDeliveries::Create([
                    'id_order' => $order->id,
                    'shiping_price' => $request->input('delivery_amount') ?? 0,// Precio de envío
                    'destination_address' => $request->input('destination_address') ?? null,
                    'destination_comuna' => $request->input('destination_comuna') ?? null,
                    'destination_region' => $request->input('destination_region') ?? null,
                    'origin' => $request->input('address_origin') ?? null,
                    'delivery_date' =>  $request->input('delivery_date'),
                    'height' => 0,
                    'weight' => 0,
                    'width' => 0,
                    'length' => 0,
                    'id_courier' => Null,
                ]);
            }
            foreach ($productsSelected as $product ) {
                //orden con detalle por producto y cantidad
                OrderDetail::Create([
                    'id_order' => $order->id,
                    'id_product' => $product->id,
                    'quantity' => 1,//por ahora solo 1 producto
                    'discount' => 0, //descuento por producto
                    'price' => $product->sale_price,
                    'total' => $product->sale_price - $order->discount,
                    'tax' => 0,// impuestos
                    'id_state' => 2, //En curso
                ]);
            }
            $request->merge([
                'wallet' => $request->input('id_wallet'),
                'amount' => $request->input('amount_paid'),
                'category' => 1,
                'description' => $request->input('amount_paid') ? 'Abono pedido N'.$order->id : 'Venta',
                'date' => now()->format('Y-m-d H:i:s'),
                'type' => 1,
                'file' => $request->file('file') ?? NULL,
            ]);

            $financeController = new FinanceController();
            $financeController->incomeExpenseStore($request);

            $correoVendedor =  Company::findOrFail($request->input('id_company'))->email;
            $correoCliente = Consumer::findOrFail($request->input('client_id'))->email;

            if ($request->input('type') == 'order/delivery') { //solo si es ORDEN envia el correo
                $data = Order::with('company', 'state', 'consumer', 'orderDeliveries', 'orderDetails.product')->findOrFail($order->id);            //enviar Correo al cliente
                $this->mailService->sendTextMail($correoCliente, 'Orden Creada N'.$order->id.' .',$data);
                $this->mailService->sendTextMail($correoVendedor, 'Respaldo Orden Creada N'.$order->id.' .', $data);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            error_log($th);
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
    public function editOrderState($id, $state)
    {
        $order = Order::findOrFail($id);
        $order->update(['id_state' => $state]);
        $order->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);   
        if ($order) {
            $order->orderDeliveries()->delete();
            $order->orderDetails()->delete();
            $order->delete();
        }
        $record = Record::where('description', 'like', 'Abono pedido N' . $order->id . '%')->first();

        if ($record) {
            $record->delete();
        }
        
        return;
    }
}
