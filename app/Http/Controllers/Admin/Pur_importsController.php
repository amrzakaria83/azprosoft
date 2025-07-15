<?php

namespace App\Http\Controllers\Admin;
set_time_limit(3600);
ini_set('max_execution_time', 4800);
ini_set('memory_limit', '4096M');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel; 
use App\Models\Pur_import;
use App\Models\Product;
use App\Models\All_pur_import;
use App\Models\Site;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Added this import
use Illuminate\Support\Facades\Auth;


class Pur_importsController extends Controller
{
   
    // public function import(Request $request)    
    // {
    //     set_time_limit(3600); 
    //     ini_set('max_execution_time', 4800); 
    //     ini_set('memory_limit', '4096M'); 

    //     $request->validate([
    //         'excel_file' => 'required|file|mimes:xls,xlsx|max:51200' 
    //     ]);

        
    //         DB::table('pur_imports')->truncate();

    //         $path = $request->file('excel_file')->getRealPath();
    //         $data = (new FastExcel)->import($path);
            
    //         if ($data->count() > 0) {
    //             // Get the first row to determine column mappings
    //             $firstRow = $data->first();
    //             $excelHeadings = array_keys($firstRow);
    //             $adddata = [];
    //             // Map database columns to Excel headers by their index in the Excel file.
    //             // Fallback to the database column name if the index is out of bounds.
    //             $headingMap = [
    //                 'product_id' => $excelHeadings[0] ?? 'product_id',
    //                 'quantity' => $excelHeadings[1] ?? 'quantity',
    //                 'balance_req' => $excelHeadings[2] ?? 'balance_req',
    //                 'note' => $excelHeadings[3] ?? 'note',
    //             ];
    //             // Map the imported data to the structure needed for Pur_import::create()
    //             foreach ($data as $excelRowData) {
                    
    //                 $create = Pur_import::create([
    //                 'product_id' => $excelRowData[$excelHeadings[0]],
    //                 'quantity' => $excelRowData[$excelHeadings[1]],
    //                 'balance_req' => $excelRowData[$excelHeadings[2]],
    //                 'note' => $excelRowData[$excelHeadings[3]],
    //                 'pro_emp_code' => Auth::guard('admin')->user()->id,
                    
    //                 ]);
    //                 $adddata =+$create;

    //             }
    //             foreach ($adddata as $adddataaz) {
                    
    //                 $createall = All_pur_import::create([
    //                 'product_id' => $adddataaz->product_id,
    //                 'quantity' => $adddataaz->quantity,
    //                 'balance_req' => $adddataaz->balance_req,
    //                 'note' => $adddataaz->note,
    //                 'status' => 0,
    //                 'status_request' => 0, //0 = waitting - 1 = pur_drug_requests
                    
    //                 'pro_emp_code' => Auth::guard('admin')->user()->id,
                    
    //                 ]);
    //                 $adddata =+$create;

    //             }
                
    //     }
    //     return redirect()->route('admin.pur_prod_imps.create')->with('success', 'Excel data imported and processed successfully!');

    // }
    public function import(Request $request)
{
    // Set execution limits
    set_time_limit(3600);
    ini_set('max_execution_time', 4800);
    ini_set('memory_limit', '4096M');

    // Validate the input
    $request->validate([
        'excel_file' => 'required|file|mimes:xls,xlsx|max:51200'
    ]);

    try {
        DB::beginTransaction();

        // Clear existing imports
        DB::table('pur_imports')->truncate();

        $path = $request->file('excel_file')->getRealPath();
        $data = (new FastExcel)->import($path);

        if ($data->count() > 0) {
            $firstRow = $data->first();
            $excelHeadings = array_keys($firstRow);
            $currentUser = Auth::guard('admin')->user()->id;

            foreach ($data as $excelRowData) {
                // Create pur_import record
                $purImport = Pur_import::create([
                    'product_id' => $excelRowData[$excelHeadings[0]] ?? null,
                    'quantity' => $excelRowData[$excelHeadings[1]] ?? null,
                    'balance_req' => $excelRowData[$excelHeadings[2]] ?? null,
                    'note' => $excelRowData[$excelHeadings[3]] ?? null,
                    'pro_emp_code' => $currentUser,
                ]);

                // Create corresponding all_pur_import record
                All_pur_import::create([
                    'product_id' => $purImport->product_id,
                    'quantity' => $purImport->quantity,
                    'balance_req' => $purImport->balance_req,
                    'note' => $purImport->note,
                    'status' => 0,
                    'status_request' => 0,
                    'pro_emp_code' => $currentUser,
                ]);
            }
        }

        DB::commit();
        return redirect()->route('admin.pur_prod_imps.create')->with('success', 'Excel data imported successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
    }
}

    public function create()
    {
        
        return view('admin.pur_import.create');
    }
    // public function create()
    // {
    //     $data = Product::first('updated_at');
    //     return view('admin.pur_prod_imp.create', compact('data'));
    // }
    // The original update() method can be removed if it's no longer called directly by any route.
    // If it was called by a route, that route should now point to a method that handles the import,
    // or the import form should submit to the route that calls the modified import() method.
    // public function update()
    // {

    //     // Start of the logic from the original update() method
    //     $prodnew = Pur_import::whereNotNull('product_id')->get();

    //     foreach ($prodnew as $prod) {
    //         $prodold = All_pur_import::where('status_request',0)->where('status', 0)->where('product_id', $prod->product_id)->first();
    //         $prodidproducts = Product::where('product_code', $prod->product_id)->first();
    //         // dd($prodidproducts);
    //         if ($prodold) {
    //             $prodold->update([
    //                 'product_name' => $prod->product_name,
    //                 'product_name_en' => $prod->product_name_en,
    //                 'quantity' => ($prod->quantity > $prodold->quantity) ? $prod->quantity : $prodold->quantity,
    //                 'stock' => $prod->stock,
    //                 'status_request' => $prod->status_request,// 0 = waitting - 1 = pur_drug_requests
    //                 'factory_name' => $prod->factory_name,
    //                 'prod_id' => $prodidproducts->id ?? null,
    //                 'sell_price' => $prod->sell_price,
    //                 'g_drug' => $prod->drug,// 0 - 1 drug or non drug
    //                 'unit_id' => $prod->unit_id,
    //                 'unit2_id' => $prod->unit2_id,
    //                 'unit3_id' => $prod->unit3_id,
    //                 'unit2_factor' => $prod->unit2_factor,
    //                 'unit3_factor' => $prod->unit3_factor,
    //             ]);
    //         } else {
    //             All_pur_import::create([ 
    //                 'product_id' => $prod->product_id,
    //                 'product_name' => $prod->product_name,
    //                 'product_name_en' => $prod->product_name_en,
    //                 'quantity' => $prod->quantity,
    //                 'stock' => $prod->stock,
    //                 'status_request' => $prod->status_request ?? 0,// 0 = waitting - 1 = pur_drug_requests
    //                 'factory_name' => $prod->factory_name,
    //                 'prod_id' => $prodidproducts->id ?? null,
    //                 'sell_price' => $prod->sell_price,
    //                 'g_drug' => $prod->drug, // 0 - 1 drug or non drug
    //                 'unit_id' => $prod->unit_id,
    //                 'unit2_id' => $prod->unit2_id,
    //                 'unit3_id' => $prod->unit3_id,
    //                 'unit2_factor' => $prod->unit2_factor,
    //                 'unit3_factor' => $prod->unit3_factor,
    //             ]);
    //         }
    //     }
    //     // End of the logic from the original update() method

    //     return redirect('/admin')->with('success', 'Excel data imported and processed successfully!');
    // }
    

}
