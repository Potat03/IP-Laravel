<?php
//Loo Wee Kiat
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\APIkey;
use Exception;
use Illuminate\Support\Facades\Log;

class AdminCustomerController extends Controller
{
    public function getAll(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::with(['Order' => function ($query) {
            $query->selectRaw('sum(total) as total, customer_id')
                ->groupBy('customer_id');
        }])
            ->when($search, function ($query, $search) {
                return $query->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('tier', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            })
            ->get();

        foreach ($customers as $customer) {
            Log::info('Customer ID: ' . $customer->customer_id . ' Total: ' . $customer->Order->sum('total'));
        }

        return view('admin.customer', compact('customers'));
    }


    public function showReportPage()
    {
        return view('admin.customer_report');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
        ]);

        $customer->status = $request->input('status');
        $customer->save();

        return response()->json(['success' => true]);
    }

    public function generateXMLReport()
    {
        $customers = Customer::with(['Order' => function ($query) {
            $query->select('created_at', 'customer_id', 'total');
        }])->get();
    
        Log::info('Customers with Order Totals:', $customers->toArray());
    
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
    
        $root = $xml->createElement('customers');
        $xml->appendChild($root);
    
        foreach ($customers as $customer) {
            $customerNode = $xml->createElement('customer');
    
            $id = $xml->createElement('id', $customer->customer_id);
            $customerNode->appendChild($id);
    
            $username = $xml->createElement('username', $customer->username);
            $customerNode->appendChild($username);
    
            $email = $xml->createElement('email', $customer->email);
            $customerNode->appendChild($email);
    
            $tier = $xml->createElement('tier', $customer->tier);
            $customerNode->appendChild($tier);
    
            $status = $xml->createElement('status', $customer->status);
            $customerNode->appendChild($status);
    
            foreach ($customer->Order as $order) {
                $orderNode = $xml->createElement('order');
    
                $orderDate = $xml->createElement('created_at', $order->created_at);
                $orderNode->appendChild($orderDate);
    
                $totalSpent = $xml->createElement('total_spent', $order->total);
                $orderNode->appendChild($totalSpent);
    
                $customerNode->appendChild($orderNode);
            }
    
            $root->appendChild($customerNode);
        }
    
        $xmlDirectory = storage_path('app/xml');
        if (!file_exists($xmlDirectory)) {
            mkdir($xmlDirectory, 0755, true);
        }
    
        $filePath = $xmlDirectory . '/customer_report.xml';
        $xml->save($filePath);
    
        return response()->download($filePath);
    }
    
    


    public function generateXSLTReport()
    {
        $xmlFile = storage_path('app/xml/customer_report.xml');
        $xsltFile = storage_path('app/xslt/customer_report.xslt');

        if (!file_exists($xmlFile) || !file_exists($xsltFile)) {
            return response()->json(['error' => 'XML or XSLT file not found.'], 404);
        }

        $xml = new \DOMDocument();
        $xml->load($xmlFile);

        $xslt = new \DOMDocument();
        $xslt->load($xsltFile);

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xslt);

        $html = $proc->transformToXML($xml);

        return response($html)->header('Content-Type', 'text/html');
    }

    public function customerReportAPI(Request $request)
    {
        try {
            $api = APIKEY::where('api_key', $request->api_key)->first();
            if (!$api) {
                return response()->json(['success' => false, 'message' => 'Invalid Request'], 400);
            }

            $customers = Customer::withSum('Order', 'subtotal')->get();

            foreach ($customers as $customer) {
                $customer->orders = $customer->orders;
            }

            return response()->json(['success' => true, 'data' => $customers], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
