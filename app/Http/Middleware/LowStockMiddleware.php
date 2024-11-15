<?php

namespace App\Http\Middleware;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LowStockMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      // Check for products with low stock
      $products = Product::where('remaining_quantity', '<=', 10)->get();

      if ($products->isNotEmpty()) {
          // Flash a warning message
          Session::flash('warning', 'Some products are running low on stock.');
      }

      return $next($request);
  }
    }

