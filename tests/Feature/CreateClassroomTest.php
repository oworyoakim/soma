<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Topic;
use App\Traits\MakesZoomHttpRequests;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateClassroomTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations, MakesZoomHttpRequests;

    /**
     * @var Classroom
     */
    protected $classroom = null;

    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
        if(!empty($this->classroom->meeting_id)){
            // we delete the test meeting/webinar from zoom
            $path = "{$this->classroom->type}s/{$this->classroom->meeting_id}";
            $this->deleteZoom($path, []);
        }
        $this->classroom = null;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateClassroom()
    {
        $this->withoutExceptionHandling();
        $this->authenticate();
        $topicData = $this->topicData();
        $topicData['module_id'] = $topicData['moduleId'];
        unset($topicData['moduleId']);
        $topic = Topic::query()->create($topicData);
        $classroomData = $this->classroomData();
        $classroomData = array_merge($classroomData, [
            'topicId' => $topic->id
        ]);

        $response = $this->post('/v1/classrooms',$classroomData, $this->getRequestHeaders());

        $response->assertStatus(200);

        $this->assertEquals(1, Classroom::query()->count());

        $this->classroom = Classroom::query()->latest()->first();

        $this->assertEquals($topic->id, $this->classroom->topic_id);

        $this->assertNotNull($this->classroom->meeting_id);
    }
}
