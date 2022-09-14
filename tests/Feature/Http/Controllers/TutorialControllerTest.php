<?php

namespace Http\Controllers;

use Tests\TestCase;
use Database\Factories\TutorialFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TutorialControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_list_all_enabled_tutorials_in_asc_order()
    {
        TutorialFactory::new()->times(2)->create();

        $this->getJson('api/v1/tutorials')
            ->assertSuccessful()
            ->assertJsonCount(2, 'data')
            ->assertDataStructure(
                [
                    [
                        'id',
                        'title',
                        'text',
                        'image',
                    ]
                ]);
    }
}
