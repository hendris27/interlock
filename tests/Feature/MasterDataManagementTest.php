<?php

namespace Tests\Feature;

use App\Models\MasterData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_master_data_can_be_edited(): void
    {
        $masterData = MasterData::create([
            'model_name' => 'Model Lama',
            'item_name' => 'ITEM-OLD',
        ]);

        $this->get(route('master-data.edit', ['master_datum' => $masterData]))
            ->assertOk()
            ->assertSee('Model Lama');

        $this->put(route('master-data.update', ['master_datum' => $masterData]), [
            'model_name' => 'Model Baru',
            'item_name' => 'ITEM-NEW',
        ])
            ->assertRedirect(route('master-data.index'))
            ->assertSessionHas('success', 'Master Data berhasil diperbarui.');

        $this->assertDatabaseHas('master_data', [
            'id' => $masterData->id,
            'model_name' => 'Model Baru',
            'item_name' => 'ITEM-NEW',
        ]);
    }

    public function test_master_data_can_be_deleted_from_database(): void
    {
        $masterData = MasterData::create([
            'model_name' => 'Model Hapus',
            'item_name' => 'ITEM-DELETE',
        ]);

        $this->delete(route('master-data.destroy', ['master_datum' => $masterData]))
            ->assertRedirect(route('master-data.index'))
            ->assertSessionHas('success', 'Master Data berhasil dihapus dari database.');

        $this->assertDatabaseMissing('master_data', ['id' => $masterData->id]);
    }

    public function test_master_data_list_can_be_filtered_and_is_paginated_by_fifteen_records(): void
    {
        foreach (range(1, 16) as $number) {
            MasterData::create([
                'model_name' => 'Model A',
                'item_name' => "A-{$number}",
            ]);
        }

        MasterData::create([
            'model_name' => 'Model B',
            'item_name' => 'B-1',
        ]);

        $this->get(route('master-data.index', ['model_name' => 'Model A']))
            ->assertOk()
            ->assertSee('A-1')
            ->assertDontSee('A-16')
            ->assertDontSee('B-1')
            ->assertSee('Halaman 1 dari 2');

        $this->get(route('master-data.index', ['model_name' => 'Model A', 'page' => 2]))
            ->assertOk()
            ->assertSee('A-16')
            ->assertSee('Halaman 2 dari 2');
    }
}
