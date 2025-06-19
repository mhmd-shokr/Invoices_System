<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesDeatailesController;
use App\Http\Controllers\InvoicesAttachementController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use Spatie\Permission\Models\Role;



use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', [DashboardController::class,'chart'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('invoices',InvoicesController::class);

Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);

Route::get('invoices/sections/{id}', [InvoicesController::class, 'getProducts']);
Route::get('invoices_deatailes/{id}', [InvoicesDeatailesController::class, 'index']);
Route::get('Status_show/{id}',[InvoicesController::class,'show'])->name('Status_show');
Route::put('Status_update/{id}',[InvoicesController::class,'Status_Update'])->name('Status.update');


Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDeatailesController::class, 'get_file'])->name('view_file');
Route::get('download_file/{invoice_number}/{file_name}', [InvoicesDeatailesController::class, 'download_file'])->name('download_file');
Route::delete('delete_file/{id}', [InvoicesDeatailesController::class, 'destroy'])->name('delete_file');



Route::post('/invoices/attachments', [InvoicesAttachementController::class, 'store'])->name('attachments.store');



Route::get('invoice_paid', [InvoicesController::class, 'invoice_paid'])->name('invoice_paid');
Route::get('invoice_unpaid', [InvoicesController::class, 'invoice_unpaid'])->name('invoice_unpaid');
Route::get('invoice_partial', [InvoicesController::class, 'invoice_partial'])->name('invoice_partial');

Route::resource('invoices_archive', ArchiveController::class);
Route::get('print_invoice/{id}',[InvoicesController::class,'print_invoice'])->name('print_invoice');


Route::get('export', [InvoicesController::class, 'export'])->name('export');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('invoices_report',[InvoicesReportController::class, 'index'])->name('invoicesReport.index');
Route::post('search_invoices',[InvoicesReportController::class, 'SearchInvoices'])->name('searchInvoices.search');

Route::get('customers_report',[CustomerReportController::class, 'index'])->name('customersReport.index');
Route::post('search_customers',[CustomerReportController::class, 'searchCustomers'])->name('searchCustomers.search');




Route::get('/{page}', [AdminController::class, 'index'])->middleware('auth');
