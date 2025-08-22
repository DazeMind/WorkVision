<?php

namespace App\Http\Controllers\Web\Inventaries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\MaterialStoreRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Material;
use App\Models\ProductsService;
use App\Models\Record;
use App\Models\Region;
use App\Models\ScheduleRecord;
use App\Models\SubCategory;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InventariesController extends Controller
{

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
        $materials = Material::whereIn('id_company', $companiesIds)->paginate(10);
    
        return Inertia::render('Inventaries/Index', [
            'products' => $productos,
            'companies' => $companies,
            'materials' => $materials,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'registros' => $registros,
            'walletTypes' => WalletType::all(),
            'programRecords' => $ScheduleRecords,
            // 'wallets' => Wallet::where('id_client', $client->id)->get(),
            'wallets' => Wallet::where('id_client', $client->id)->with('records')->get(),
        ]);
    }

    public function create()
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
    
        return Inertia::render('Inventaries/Create', [
            'products' => $productos,
            'companies' => $companies,
            'regions' => Region::with('province.comuna')->get(),
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'registros' => $registros,
            'walletTypes' => WalletType::all(),
            'programRecords' => $ScheduleRecords,
            // 'wallets' => Wallet::where('id_client', $client->id)->get(),
            'wallets' => Wallet::where('id_client', $client->id)->with('records')->get(),
        ]);
    }

    public function store(MaterialStoreRequest $request)
    {
        echo "llego";
        $material = Material::create([
            'id_company'=> $request->input('id_company'),
            'name'=> $request->input('name'),
            'type' => $request->input('type'),
            'unit_of_measure'=> $request->input('unit_of_measure') ?? 'Unidad',
            'stock'=> $request->input('stock') ?? 1,
            'purchase_price'=> $request->input('purchase_price'),
            'low_stock_threshold'=> $request->input('low_stock_threshold') ?? 0,
            'description'=> $request->input('description'),
        ]);
        
        // elseif (condition) {
        //     $Producto = ProductsService::Create([
        //         'type' => $request->input('type'),
        //         'name'=> $request->input('name'),
        //         'id_company'=> $request->input('id_company'),
        //         'description'=> $request->input('description'),
        //         'sale_price'=> $request->input('sale_price'),
        //         'purchase_price'=> $request->input('purchase_price'),
        //         'SKU'=> $request->input('sku'),
        //         'height'=> 0,
        //         'weight'=> 0,
        //         'width'=> 0,
        //         'length'=> 0,
        //     ]);
        // }
        


        

        return Redirect::route('inventarios');

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
    public function stock()
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {

    }
}
