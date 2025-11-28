<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

final class CartController extends Controller
{
    public function index(#[CurrentUser()] User $user): View
    {
        $cart = $user->cart()->first();

        $cartItems = $cart
            ? $cart->items()
                ->with([
                    'course' => function ($query): void {
                        $query->withCount(['enrollments', 'lessons'])
                            ->with(['category', 'teacher.profile']);
                    },
                ])
                ->paginate(3)
            : collect();

        return view('pages.cart', [
            'cartItems' => $cartItems,
        ]);
    }
    public function show(#[CurrentUser()] User $user, Course $course): View
    {
        $cart = $user->cart;
        $course->loadCount(['lessons', 'enrollments']);
        return view('pages.show-cart', [
            'cart' => $cart,
            'course' => $course,
        ]);
    }

    public function store(#[CurrentUser()] User $user, Course $course): RedirectResponse
    {
        return DB::transaction(function () use ($user, $course): RedirectResponse {
            $cart = $user->cart()->create();

            $cart->items()->create(['course_id' => $course->id]);

            return redirect()->route('carts.index')->with('success', 'item has been added');
        });
    }

    public function destroy(#[CurrentUser()] User $user, Cart $cart, Course $course): RedirectResponse
    {
        $cart->items()->where('course_id', $course->id)->delete();
        $user->cart()->forceDelete();

            return redirect()->route('carts.index')->with('success', 'item has been deleted');
    }
}
