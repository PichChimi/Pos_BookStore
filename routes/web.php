<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LocalizationController;
use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/locale/{locale}',[LocalizationController::class, 'setLang'])->name('lang');

// Route::get('/sales-report/export', function () {
//     return Excel::download(new SalesReportExport, 'sales_report.xlsx');
// })->name('sales.report.export');


Route::group([
     'middleware' => 'auth'
 ],function(){
   
    Route::get('/', function () {
        dd(Session::all()); // Check all session values
    })->name('page.index');
    
    Route::get('/', [App\Http\Controllers\PageController::class, 'index'])->name('page.index');
    Route::get('/sale', [App\Http\Controllers\PageController::class, 'sale'])->name('page.sale');
    // Route::get('/cart', [App\Http\Controllers\PageController::class, 'sale'])->name('page.cart-summary');
    
    Route::group([
        'prefix' => 'user'
     ],function(){
         Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
         Route::post('/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
         Route::put('update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
         Route::get('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit'); // For loading user data in modal
         Route::delete('/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
         Route::post('/delete-selected', [App\Http\Controllers\UserController::class, 'deleteSelected'])->name('user.deleteSelected');
    
     });
    
    Route::group([
         'prefix' => 'role',
        //  'middleware' => ['auth']
    ], function(){
            Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
            Route::post('/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
            Route::put('/update', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
            Route::delete('/delete', [App\Http\Controllers\RoleController::class, 'delete'])->name('role.delete');
            Route::post('/delete-selected', [App\Http\Controllers\RoleController::class, 'deleteSelected'])->name('roles.deleteSelected');
    });
    
    Route::group([
        'prefix' => 'genres'
     ],function(){
         Route::get('/', [App\Http\Controllers\GenresController::class, 'index'])->name('genres.index');
         Route::post('/store', [App\Http\Controllers\GenresController::class, 'store'])->name('genres.store');
         Route::put('/update', [App\Http\Controllers\GenresController::class, 'update'])->name('genres.update');
         Route::delete('/delete', [App\Http\Controllers\GenresController::class, 'delete'])->name('genres.delete');
         Route::post('/delete-selected', [App\Http\Controllers\GenresController::class, 'deleteSelected'])->name('genres.deleteSelected');
     });
    
     Route::group([
        'prefix' => 'author'
     ],function(){
         Route::get('/', [App\Http\Controllers\AuthorsController::class, 'index'])->name('author.index');
         Route::post('/store', [App\Http\Controllers\AuthorsController::class, 'store'])->name('author.store');
         Route::put('/update', [App\Http\Controllers\AuthorsController::class, 'update'])->name('author.update');
         Route::delete('/delete', [App\Http\Controllers\AuthorsController::class, 'delete'])->name('author.delete');
         Route::post('/delete-selected', [App\Http\Controllers\AuthorsController::class, 'deleteSelected'])->name('author.deleteSelected');
     });
    
     Route::group([
        'prefix' => 'book'
    ], function () {
        Route::get('/', [App\Http\Controllers\BookController::class, 'index'])->name('book.index');
        Route::post('/store', [App\Http\Controllers\BookController::class, 'store'])->name('book.store');
        Route::put('/update/{id}', [App\Http\Controllers\BookController::class, 'update'])->name('book.update');
        Route::get('/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('book.edit'); // For loading user data in modal
        Route::delete('/delete', [App\Http\Controllers\BookController::class, 'delete'])->name('book.delete');
        Route::post('/delete-selected', [App\Http\Controllers\BookController::class, 'deleteSelected'])->name('book.deleteSelected');
        Route::get('/books-by-genre', [App\Http\Controllers\BookController::class, 'getBooksByGenre'])->name('books.by.genre');
    });
    
    Route::group([
        'prefix' => 'supplier'
     ],function(){
         Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
         Route::post('/store', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
         Route::put('/update', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
         Route::delete('/delete', [App\Http\Controllers\SupplierController::class, 'delete'])->name('supplier.delete');
         Route::post('/delete-selected', [App\Http\Controllers\SupplierController::class, 'deleteSelected'])->name('supplier.deleteSelected');
     });

     Route::group([
        'prefix' => 'stock'
     ],function(){
         Route::get('/', [App\Http\Controllers\StockController::class, 'index'])->name('stock.index');
         Route::post('/store', [App\Http\Controllers\StockController::class, 'store'])->name('stock.store');
         Route::put('/update', [App\Http\Controllers\StockController::class, 'update'])->name('stock.update');
         Route::delete('/delete', [App\Http\Controllers\StockController::class, 'delete'])->name('stock.delete');
         Route::post('/delete-selected', [App\Http\Controllers\StockController::class, 'deleteSelected'])->name('stock.deleteSelected');
     });

     Route::group([
        'prefix' => 'cart'
     ],function(){
        
         Route::post('/store', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
         Route::get('/summary', [App\Http\Controllers\CartController::class, 'getCartSummary'])->name('cart.summary');
         Route::post('/update/{cartId}', [App\Http\Controllers\CartController::class, 'updateCartItem'])->name('cart.updateCartItem');
         Route::delete('/remove/{cartId}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
         Route::post('/add-by-barcode', [App\Http\Controllers\CartController::class, 'addToCartByBarcode'])->name('cart.addByBarcode');
         Route::post('/pay', [App\Http\Controllers\CartController::class, 'pay'])->name('cart.pay');

     });

    //  Route::get('/reports/sales', [App\Http\Controllers\ReportController::class, 'salesReport'])->name('reports.sales');
     
     Route::get('/reports/sales', [App\Http\Controllers\ReportController::class, 'salesReport'])->name('reports.sales');
     Route::get('sales/report/export', [App\Http\Controllers\ReportController::class, 'exportSalesReport'])->name('sales.report.export');
     Route::get('/reports/employee-sales', [App\Http\Controllers\ReportController::class, 'getEmployeeSalesReport'])->name('reports.employeeSales');
     Route::get('employee-sales-report/export', [App\Http\Controllers\ReportController::class, 'exportEmployeeSalesReport'])->name('employeeSalesReport.export');
    
    
 });





