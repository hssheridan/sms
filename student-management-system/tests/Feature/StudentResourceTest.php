<?php

namespace Tests\Feature;

use App\Filament\Resources\StudentResource;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Filament\Resources\StudentResource\Pages\ViewStudent;
use App\Models\Student;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class StudentResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function it_can_render_student_list()
    {
        $this->get(StudentResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_student_create_page()
    {
        $this->get(StudentResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_new_student()
    {
        $student = Student::factory()->make();

        $this->assertDatabaseEmpty('students');

        Livewire::test(CreateStudent::class)
            ->set('data.name', $student->name)
            ->set('data.email', $student->email)
            ->set('data.bio', $student->bio)
            ->set('data.date_of_birth', $student->date_of_birth)
            ->set('data.advisor_id', $student->advisor_id)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('students', 1);
        $this->assertDatabaseHas('students', [
            'name' => $student->name,
            'email' => $student->email,
            'bio' => $student->bio,
            'date_of_birth' => $student->date_of_birth,
            'advisor_id' => $student->advisor_id,
        ]);
    }

    /** @test */
    public function student_creation_has_validation()
    {
        $this->assertDatabaseEmpty('students');

        Livewire::test(CreateStudent::class)
            ->set('data.name',null)
            ->set('data.email', null)
            ->set('data.bio', null)
            ->set('data.date_of_birth', null)
            ->set('data.advisor_id', null)
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'required',
                'bio' => 'required',
                'date_of_birth' => 'required',
            ]);

        $this->assertDatabaseEmpty('students');
    }

    /** @test */
    public function email_must_be_unique_when_creating_student()
    {
        $student1 = Student::factory()->create();
        $student2 = Student::factory()->make(['email' => $student1->email]);

        $this->assertDatabaseCount('students', 1);

        Livewire::test(CreateStudent::class)
            ->set('data.name', $student2->name)
            ->set('data.email', $student2->email)
            ->set('data.bio', $student2->bio)
            ->set('data.date_of_birth', $student2->date_of_birth)
            ->set('data.advisor_id', $student2->advisor_id)
            ->call('create')
            ->assertHasFormErrors([
                'email' => 'unique',
            ]);

        $this->assertDatabaseCount('students', 1);
    }

    /** @test */
    public function it_can_render_view_page_for_a_student()
    {
        $this->get(StudentResource::getUrl('view', [
            'record' => Student::factory()->create(),
        ]))
            ->assertSuccessful();
    }

    /** @test */
    public function it_retrieves_correct_data_when_viewing_student()
    {
        $student = Student::factory()->create();

        Livewire::test(ViewStudent::class, [
            'record' => $student->id
        ])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_render_student_edit_page()
    {
        $student = Student::factory()->create();

        Livewire::test(ViewStudent::class, [
            'record' => $student->id
        ])
            ->assertSuccessful();
    }

    /** @test */
    public function it_retrieves_correct_data_to_edit()
    {
        $student = Student::factory()->create();

        Livewire::test(EditStudent::class, [
            'record' => $student->id
        ])
        ->assertFormSet([
                'name' => $student->name,
                'email' => $student->email,
                'bio' => $student->bio,
                'date_of_birth' => $student->date_of_birth,
                'advisor_id' => $student->advisor_id,
        ]);
    }

    /** @test */
    public function it_can_update_student()
    {
        $student = Student::factory()->create();
        $newStudent = Student::factory()->make();

        Livewire::test(EditStudent::class, [
            'record' => $student->id
        ])
        ->set('data.name', $newStudent->name)
        ->set('data.email', $newStudent->email)
        ->set('data.bio', $newStudent->bio)
        ->set('data.date_of_birth', $newStudent->date_of_birth)
        ->set('data.advisor_id'. $newStudent->advisor_id)
        ->call('save')
        ->assertHasNoErrors();

        $this->assertDatabaseCount('students', 1);
        $this->assertDatabaseHas('students', [
            'name' => $newStudent->name,
            'email' => $newStudent->email,
            'bio' => $newStudent->bio,
            'date_of_birth' => $newStudent->date_of_birth,
            'advisor_id' => $newStudent->advisor_id,
        ]);
    }

    /** @test */
    public function student_update_has_validation()
    {
        $student = Student::factory()->create();

        Livewire::test(EditStudent::class, [
            'record' => $student->id
        ])
            ->set('data.name',null)
            ->set('data.email', null)
            ->set('data.bio', null)
            ->set('data.date_of_birth', null)
            ->set('data.advisor_id', null)
            ->call('save')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'required',
                'bio' => 'required',
                'date_of_birth' => 'required',
            ]);

            $this->assertDatabaseCount('students', 1);
            $this->assertDatabaseHas('students', [
                'name' => $student->name,
                'email' => $student->email,
                'bio' => $student->bio,
                'date_of_birth' => $student->date_of_birth,
                'advisor_id' => $student->advisor_id,
            ]);
    }

    /** @test */
    public function email_must_be_unique_when_updating_student()
    {
        $student1 = Student::factory()->create();
        $student2 = Student::factory()->create();
        $newStudent = Student::factory()->make(['email' => $student1->email]);

        Livewire::test(EditStudent::class, [
            'record' => $student2->id
        ])
            ->set('data.name', $newStudent->name)
            ->set('data.email', $newStudent->email)
            ->set('data.bio', $newStudent->bio)
            ->set('data.date_of_birth', $newStudent->date_of_birth)
            ->set('data.advisor_id'. $newStudent->advisor_id)
            ->call('save')
            ->assertHasFormErrors([
                'email' => 'unique',
            ]);

        $this->assertDatabaseCount('students', 2);
        $this->assertDatabaseHas('students', [
            'name' => $student2->name,
            'email' => $student2->email,
            'bio' => $student2->bio,
            'date_of_birth' => $student2->date_of_birth,
            'advisor_id' => $student2->advisor_id,
        ]);
    }

    /** @test */
    public function it_can_delete_student()
    {
        $student = Student::factory()->create();

        $this->assertDatabaseCount('students', 1);

        Livewire::test(EditStudent::class, [
            'record' => $student->id
        ])
            ->callAction(DeleteAction::class);

        $this->assertDatabaseEmpty('students');
    }
}
