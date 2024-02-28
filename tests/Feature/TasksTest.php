<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;


class TasksTest extends TestCase
{
    // use RefreshDatabase;

   
 /**
     * Test index method.
     *
     * @return void
     */
    public function testIndexMethod()
    {
        $user=User::factory()->create();
        $this->actingAs($user);
        // Send request to index endpoint
        $response = $this->getJson('/api/tasks');
        
        // Assert response
        $response->assertStatus(200);
    }
    public function testStoreMethod()
    {
        $user=User::factory()->create();
        $this->actingAs($user);
        // Send request to index endpoint
        $response = $this->postJson('/api/tasks',[
            "title"=>"title 22",
            "priorite"=>"high",
            "description"=>"desc 22",
            "end_date"=>"",
            "status"=>"en cours",
        ]);
        
        // Assert response
        $response->assertStatus(200);
    }
    public function testUpdateMethod()
    {
        $user=User::factory()->create();
        $this->actingAs($user);
        $task=Task::create([
            "title" => 'gagag',
            "description"=>'gaga',
            "priorite"=>'low',
            "status"=>'en cours',
            "user_id"=>$user->id,
        ]);

        // Send request to index endpoint
        $response = $this->putJson("/api/tasks/update/$task->id",[
            "title"=>"title 55",
            "priorite"=>"high",
            "description"=>"desc 55",
            "status"=>"en cours",
        ]);
        
        // Assert response
        $response->assertStatus(200);
    }
    public function testDestroyMethod(){
        $user=User::factory()->create();
        $this->actingAs($user);
        $task=Task::create([
            "title" => 'sosos',
            "description"=>'soso',
            "priorite"=>'low',
            "status"=>'en cours',
            "user_id"=>$user->id,
        ]);
        $response = $this->deleteJson("/api/tasks/destroy/$task->id");
        $response->assertStatus(200);
    }



}