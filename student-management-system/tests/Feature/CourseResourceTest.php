<?php

namespace Tests\Feature;

use App\Models\User;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseResource\Pages\CreateCourse;
use App\Filament\Resources\CourseResource\Pages\EditCourse;
use App\Filament\Resources\CourseResource\Pages\ViewCourse;
use App\Models\Course;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CourseResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }
    
    /** @test */
    public function it_can_render_course_list()
    {
        $this->get(CourseResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_course_create_page()
    {
        $this->get(CourseResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_new_course()
    {
        $course = Course::factory()->make();

        $this->assertDatabaseEmpty('courses');

        Livewire::test(CreateCourse::class)
            ->set('data.name', $course->name)
            ->set('data.advisor_id', $course->advisor_id)
            ->call('create')
            ->assertHasNoErrors();
        
        $this->assertDatabaseCount('courses', 1);
        $this->assertDatabaseHas('courses', [
            'name' => $course->name,
            'advisor_id' => $course->advisor_id,
        ]);
    }

    /** @test */
    public function course_creation_has_validation()
    {
        $this->assertDatabaseEmpty('courses');

        Livewire::test(CreateCourse::class)
            ->set('data.name', null)
            ->set('data.advisor_id', null)
            ->call('create')
            ->assertHasFormErrors(['name' => 'required']);
        
        $this->assertDatabaseEmpty('courses');
    }

    /** @test */
    public function it_can_render_view_page_for_a_course()
    {
        $this->get(CourseResource::getUrl('view', [
            'record' => Course::factory()->create(),
        ]))
            ->assertSuccessful();
    }

    /** @test */
    public function it_retrieves_correct_data_when_viewing_course()
    {
        $course = Course::factory()->create();

        Livewire::test(ViewCourse::class, [
            'record' => $course->id
        ])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_render_course_edit_page()
    {
        $course = Course::factory()->create();

        Livewire::test(ViewCourse::class, [
            'record' => $course->id
        ])
            ->assertSuccessful();
    }

    /** @test */
    public function it_retrieves_correct_data_to_edit()
    {
        $course = Course::factory()->create();

        Livewire::test(EditCourse::class, [
            'record' => $course->id
        ])
        ->assertFormSet([
                'name' => $course->name,
                'advisor_id' => $course->advisor_id,
        ]);
    }

    /** @test */
    public function it_can_update_course()
    {
        $course = Course::factory()->create();
        $newCourse = Course::factory()->make();

        Livewire::test(EditCourse::class, [
            'record' => $course->id
        ])
            ->set('data.name', $newCourse->name)
            ->set('data.advisor_id'. $newCourse->advisor_id)
            ->call('save')
            ->assertHasNoErrors();
        
        $this->assertDatabaseCount('courses', 1);
        $this->assertDatabaseHas('courses', [
            'name' => $newCourse->name,
            'advisor_id' => $newCourse->advisor_id,
        ]);
    }

    /** @test */
    public function course_update_has_validation()
    {
        $course = Course::factory()->create();

        Livewire::test(EditCourse::class, [
            'record' => $course->id
        ])
            ->set('data.name', null)
            ->set('data.advisor_id'. null)
            ->call('save')
            ->assertHasFormErrors(['name' => 'required']);
        
        $this->assertDatabaseCount('courses', 1);
        $this->assertDatabaseHas('courses', [
            'name' => $course->name,
            'advisor_id' => $course->advisor_id,
        ]);
    }

    /** @test */
    public function it_can_delete_course()
    {
        $course = Course::factory()->create();

        $this->assertDatabaseCount('courses', 1);

        Livewire::test(EditCourse::class, [
            'record' => $course->id
        ])
            ->callAction(DeleteAction::class);

        $this->assertDatabaseEmpty('courses');
    }
}
