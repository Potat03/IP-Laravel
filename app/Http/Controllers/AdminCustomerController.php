<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function getAll(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('tier', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        })->get();

        return view('admin.customer', compact('customers'));
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


    // public function generateXML()
    // {
    //     $customers = Customer::all();

    //     $xml = new \DOMDocument('1.0', 'UTF-8');
    //     $xml->formatOutput = true;

    //     $root = $xml->createElement('customers');
    //     $xml->appendChild($root);

    //     foreach ($customers as $customer) {
    //         $customerNode = $xml->createElement('customer');

    //         $id = $xml->createElement('id', $customer->customer_id);
    //         $customerNode->appendChild($id);

    //         $username = $xml->createElement('username', $customer->username);
    //         $customerNode->appendChild($username);

    //         $email = $xml->createElement('email', $customer->email);
    //         $customerNode->appendChild($email);

    //         $tier = $xml->createElement('tier', $customer->tier);
    //         $customerNode->appendChild($tier);

    //         $status = $xml->createElement('status', $customer->status);
    //         $customerNode->appendChild($status);

    //         $root->appendChild($customerNode);
    //     }

    //     if (!file_exists(resource_path('storage'))) {
    //         mkdir(resource_path('storage'), 0755, true);
    //     }

    //     $filePath = resource_path('storage/customers.xml');
    //     $xml->save($filePath);

    //     return response()->download($filePath);
    // }

    // public function generateXSLTReport()
    // {
    //     $xml = new \DOMDocument();
    //     $xml->load(resource_path('storage/customers.xml')); // Load from storage

    //     $xsl = new \DOMDocument();
    //     $xsl->load(resource_path('storage/customers_report.xsl')); // XSLT also in storage

    //     $proc = new \XSLTProcessor();
    //     $proc->importStylesheet($xsl);

    //     $html = $proc->transformToXML($xml);

    //     return response($html)->header('Content-Type', 'text/html');
    // }
}
