<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChangeModelPinTest extends TestCase
{
    public function test_correct_four_digit_pin_is_accepted(): void
    {
        config(['services.interlock.model_change_pin' => '0000']);

        $this->postJson(route('change-model.verify-pin'), ['pin' => '0000'])
            ->assertOk()
            ->assertExactJson(['success' => true]);
    }

    public function test_incorrect_pin_is_rejected(): void
    {
        config(['services.interlock.model_change_pin' => '0000']);

        $this->postJson(route('change-model.verify-pin'), ['pin' => '1234'])
            ->assertUnprocessable()
            ->assertExactJson([
                'success' => false,
                'message' => 'PIN tidak sesuai.',
            ]);
    }

    public function test_pin_must_contain_exactly_four_digits(): void
    {
        config(['services.interlock.model_change_pin' => '0000']);

        $this->postJson(route('change-model.verify-pin'), ['pin' => '00a0'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('pin');
    }
}
