<?php

use App\Livewire\Forms\CategorySelect;
use App\Models\Category;
use Livewire\Livewire;

test('when an active category is created it appears on the select list', function (): void {
    $categoryA = Category::factory()->create(['status' => 1]);
    Livewire::test(CategorySelect::class)
        ->assertOk()
        ->assertSee($categoryA->name)
        ->assertViewHas('queryCategories')
        ->assertSee([$categoryA->name]);
});
test('when a category is created as inactive it does not appear on the select list', function (): void {
    $category = Category::factory()->create(['status' => 0]);

    Livewire::test(CategorySelect::class)
        ->assertOk()
        ->assertDontSee($category->name);
});
