<?php

namespace Tests\Feature;

use App\Models\MasterData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_master_data_edit_route_loads_and_updates_record(): void
    {
        $record = MasterData::create([
            'model_name' => 'Laptop Dell',
            'item_name' => 'Battery 6 Cell',
        ]);

        $editResponse = $this->get('/master-data/' . $record->id . '/edit');
        $editResponse->assertOk()
            ->assertSee('Edit Master Data')
            ->assertSee('Laptop Dell');

        $updateResponse = $this->put('/master-data/' . $record->id, [
            'model_name' => 'Laptop Dell',
            'item_name' => 'Keyboard Mechanical',
        ]);

        $updateResponse->assertRedirect('/master-data');
        $this->assertDatabaseHas('master_data', [
            'id' => $record->id,
            'item_name' => 'Keyboard Mechanical',
        ]);
    }

    public function test_master_data_delete_route_removes_record(): void
    {
        $record = MasterData::create([
            'model_name' => 'Printer Canon',
            'item_name' => 'Toner Cartridge Black',
        ]);

        $deleteResponse = $this->delete('/master-data/' . $record->id);

        $deleteResponse->assertRedirect('/master-data');
        $this->assertDatabaseMissing('master_data', [
            'id' => $record->id,
        ]);
    }
}
