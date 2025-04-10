<?php

declare(strict_types=1);

use App\Livewire\Category\ManageCategories;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->signIn($this->user);
});

test('Category Validation rules on save', function ($field, $value, $rule): void {
    Livewire::test(ManageCategories::class)
        ->set($field, $value)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with('category_validation');

test('When a user hits the add button the create form is shown', function (): void {
    Livewire::test(ManageCategories::class)
        ->call('showAddForm')
        ->assertSee('Add Category')
        ->assertSee('Save');
});

test('When a user hits the edit button the update form is shown', function (): void {
    Livewire::test(ManageCategories::class)
        ->call('showEditForm')
        ->assertSee('Edit Category')
        ->assertSee('Save');
});

test('When a user hits the show table button the main table is shown', function (): void {
    Livewire::test(ManageCategories::class)
        ->call('showTable')
        ->assertSee('Categories')
        ->assertDontSee('Edit Category')
        ->assertSee('Add Category');
});
