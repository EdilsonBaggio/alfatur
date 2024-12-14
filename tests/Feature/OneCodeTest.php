<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\OneCodeController;
use App\Models\Grupos;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OneCodeTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function test_getGrupos(): void
    {
        $oneCode = new OneCodeController();
        $response = $oneCode->getGrupos();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_saveGrupos_should_save(): void
    {
        $oneCode = new OneCodeController();
        $grupos[] = ['number'=>'1293783283746','name'=>'teste','id'=>4];

        $oneCode->saveGrupos($grupos);
        $grupo = ['nome'=>'teste','onecode_id'=>4,'numero'=>1293783283746];

        $this->assertDatabaseHas('grupos',$grupo);
    }

    public function test_saveGrupos_should_dont_save(): void
    {
        $oneCode = new OneCodeController();
        $grupos = [
            ['name'=>'teste2','id'=>44],
            ['id'=>55, 'number'=>192837136457],
            ['name'=>'teste2','number'=>192837136457],
        ];

        $oneCode->saveGrupos($grupos);

        foreach($grupos as $grupo){
            $this->assertDatabaseMissing('grupos',$grupo);
        }
    }
}
