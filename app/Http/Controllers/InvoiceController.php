<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    function invoiceCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');

            $customer_id = $request->input('customer_id');

            $invoice =  Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
            ]);

            $invoice_id = $invoice->id;

            $products = $request->input('products');

            foreach ($products as $eachProduct) {
                InvoiceProduct::create([
                    'invoice_id' => $invoice_id,
                    'product_id' => $eachProduct['product_id'],
                    'qty' => $eachProduct['qty'],
                    'sale_price' => $eachProduct['sale_price'],
                ]);
            }

            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }

    function displayInvoice(Request $request)
    {

        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }

    function invoiceDetails(Request $request)
    {
        $user_id = $request->header('id');
        $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->input('customer_id'))->first();
        $invoiceTotal = Invoice::where('user_id', $user_id)->where('id', $request->input('invoice_id'))->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', $request->input('invoice_id'))->get();
        return array(
            'customer' => $customerDetails,
            'invoice' => $invoiceTotal,
            'product' => $invoiceProduct,
        );
    }

    function invoiceDelete(Request $request)
    {
       DB::beginTransaction();
        try {

            $user_id = $request->header('id');
            InvoiceProduct::where('invoice_id', $request->input('invoice_id'))->delete();
            Invoice::where('user_id', $user_id)->where('id', $request->input('invoice_id'))->delete();

            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
}
