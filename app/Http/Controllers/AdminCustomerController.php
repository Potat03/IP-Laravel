<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function getAll(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::withSum('Order', 'subtotal')
            ->when($search, function ($query, $search) {
                return $query->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('tier', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            })->get();

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
        $customers = Customer::withSum('Order', 'subtotal')->get();

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

            $totalSpent = $xml->createElement('total_spent', $customer->orders_sum_subtotal);
            $customerNode->appendChild($totalSpent);

            $root->appendChild($customerNode);
        }

        $xmlDirectory = storage_path('app/xml');
        if (!file_exists($xmlDirectory)) {
            mkdir($xmlDirectory, 0755, true);
        }

        $filePath = $xmlDirectory . '/customer_report.xml';
        $xml->save($filePath);

        if (request()->is('api/*')) {
            return response()->file($filePath)->header('Content-Type', 'application/xml');
        }

        return response()->download($filePath);
    }



    public function generateXSLTReport()
    {
        $xmlFile = storage_path('app/xml/customer_report.xml');
        $xsltFile = storage_path('app/xslt/customer_report.xslt');

        if (!file_exists($xmlFile) || !file_exists($xsltFile)) {
            if (request()->is('api/*')) {
                return response()->json(['error' => 'XML or XSLT file not found.'], 404);
            } else {
                return response()->view('errors.404', ['message' => 'XML or XSLT file not found.'], 404);
            }
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
}
