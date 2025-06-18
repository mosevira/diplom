<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch; // Import the Branch model

class InvoiceController extends Controller
{
    public function index()
    {
        // Get invoices for all branches for admin, otherwise for the current branch
        $user = Auth::user();
        $branches = Branch::all();
        $products = Product::all(); // Получаем все товары

        return view('invoices.create', compact('branches', 'products'));
        $invoices = Invoice::when($user->role !== 'admin', function ($query) use ($user) {
            $query->where('branch_id', $user->branch_id);
        })->get();

        return view('invoices.index', compact('invoices', 'branches','products'));
    }

    public function create()
    {
        $user = Auth::user();
        $branches = Branch::all();
        $products = Product::all();
        if ($user->role === 'admin') {
            $products = Product::all();
        } else {

            $products = Product::where('branch_id', $user->branch_id)->get();
        }

        return view('invoices.create', compact('products', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'product_quantities' => 'nullable|array', // Позволяем массиву product_quantities быть пустым
        ]);

        try {
            $invoice = Invoice::create([
                'branch_id' => $request->branch_id,
                'date' => $request->date,
                'status' => 'pending',
            ]);

            // Проверяем, что массив product_quantities существует и не пустой
            if ($request->has('product_quantities') && is_array($request->product_quantities)) {
                // Сохраняем информацию о товарах и их количествах в связанную таблицу (например, invoice_items)
                foreach ($request->product_quantities as $product_id => $quantity) {
                    if ($quantity > 0) {
                        // Создаем запись в таблице invoice_items
                        try {
                            DB::table('invoice_items')->insert([
                                'invoice_id' => $invoice->id,
                                'product_id' => $product_id,
                                'quantity' => $quantity,
                            ]);
                        } catch (\Exception $e) {
                            // Если возникла ошибка при вставке одного товара, логируем ее и продолжаем
                            \Log::error('Ошибка при вставке товара в invoice_items: ' . $e->getMessage());
                            continue; // Переходим к следующему товару
                        }
                    }
                }
            }

            if (Auth::user()->role === 'admin') {
                return redirect()->route('invoices.index')->with('success', 'Накладная успешно создана.');
            } else {
                return redirect()->route('storekeeper.dashboard')->with('success', 'Накладная успешно создана.');
            }
        } catch (\Exception $e) {
            // Если возникла ошибка, возвращаемся на форму с ошибками и передаем $branches
            return redirect()->back()
                ->withInput() // Сохраняем введенные данные
                ->withErrors(['message' => 'Ошибка при создании накладной: ' . $e->getMessage()]) // Передаем сообщение об ошибке
                ->with('branches', Branch::all()); // Передаем список филиалов
        }
    }

    public function show(Invoice $invoice)
    {
        $user = Auth::user();
      
        \Log::info('User role: ' . $user->role);
        \Log::info('User branch_id: ' . $user->branch_id);
        \Log::info('Invoice branch_id: ' . $invoice->branch_id);

        if ($user->role !== 'admin' && $invoice->branch_id !== $user->branch_id) {
            abort(403, 'У вас нет прав для просмотра этой накладной.');
        }

        return view('invoices.show', compact('invoice'));
    }

    public function approve(Invoice $invoice)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $invoice->branch_id !== $user->branch_id) {
            abort(403, 'У вас нет прав для подтверждения этой накладной.');
        }

        $invoice->status = 'confirmed';
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Накладная подтверждена.');
    }

    public function reject(Invoice $invoice)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $invoice->branch_id !== $user->branch_id) {
            abort(403, 'У вас нет прав для отклонения этой накладной.');
        }

        $invoice->status = 'rejected';
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Накладная отклонена.');
    }
        public function showForSeller(Invoice $invoice)
    {
        $user = Auth::user();

        // Проверяем, что накладная относится к селлеру
        if ($invoice->seller_id !== $user->id) {
            abort(403, 'У вас нет прав для просмотра этой накладной.');
        }

        return view('invoices.show_seller', compact('invoice'));
    }
}
