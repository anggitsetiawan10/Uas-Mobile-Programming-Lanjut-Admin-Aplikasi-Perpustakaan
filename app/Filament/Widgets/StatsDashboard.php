<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReturnBookResource;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\ReturnBook;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Buku', Book::count()),
            Stat::make('Jumlah Kategori', Category::count()),
            Stat::make('Total User Terdaftar', User::count()),
            Stat::make('Peminjaman Aktif', Loan::where('status', 'dipinjam')->count()),
            Stat::make('Pengembalian Hari Ini', ReturnBook::whereDate('return_date', today())->count()),
        ];
    }
}
