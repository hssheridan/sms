<?php

namespace Tests\Feature;

use App\Filament\Resources\AdvisorResource;
use App\Filament\Resources\AdvisorResource\Pages\CreateAdvisor;
use App\Filament\Resources\AdvisorResource\Pages\EditAdvisor;
use App\Filament\Resources\AdvisorResource\Pages\ViewAdvisor;
use App\Models\Advisor;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AdvisorResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function it_can_render_advisor_list()
    {
        $this->get(AdvisorResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_advisor_create_page()
    {
        $this->get(AdvisorResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_new_advisor()
    {
        $advisor = Advisor::factory()->make();

        $this->assertDatabaseEmpty('advisors');

        Livewire::test(CreateAdvisor::class)
            ->set('data.name', $advisor->name)
            ->set('data.email', $advisor->email)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('advisors', 1);
        $this->assertDatabaseHas('advisors', [
            'name' => $advisor->name,
            'email' => $advisor->email,
        ]);
    }

    /** @test */
    public function advisor_creation_has_validation()
    {
        $this->assertDatabaseEmpty('advisors');

        Livewire::test(CreateAdvisor::class)
            ->set('data.name',null)
            ->set('data.email', null)
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'required',
            ]);

        $this->assertDatabaseEmpty('advisors');
    }

    /** @test */
    public function email_must_be_unique_when_creating_advisor()
    {
        $advisor1 = Advisor::factory()->create();
        $advisor2 = Advisor::factory()->make(['email' => $advisor1->email]);

        $this->assertDatabaseCount('advisors', 1);

        Livewire::test(CreateAdvisor::class)
            ->set('data.name', $advisor2->name)
            ->set('data.email', $advisor2->email)
            ->call('create')
            ->assertHasFormErrors([
                'email' => 'unique',
            ]);

        $this->assertDatabaseCount('advisors', 1);
    }

    /** @test */
    public function it_can_render_view_page_for_an_advisor()
    {
        $this->get(AdvisorResource::getUrl('view', [
            'record' => Advisor::factory()->create(),
        ]))
            ->assertSuccessful();
    }

    /** @test */
    public function it_retrieves_correct_data_when_viewing_advisor()
    {
        $advisor = Advisor::factory()->create();

        Livewire::test(ViewAdvisor::class, [
            'record' => $advisor->id
        ])
            ->assertHasNoErrors();
    }

    /** @test */
    public function it_can_render_advisor_edit_page()
    {
        $advisor = Advisor::factory()->create();

        Livewire::test(ViewAdvisor::class, [
            'record' => $advisor->id
        ])
            ->assertSuccessful();
    }

    /** @test */
    public function it_retrieves_correct_data_to_edit()
    {
        $advisor = Advisor::factory()->create();

        Livewire::test(EditAdvisor::class, [
            'record' => $advisor->id
        ])
        ->assertFormSet([
                'name' => $advisor->name,
                'email' => $advisor->email,
        ]);
    }

    /** @test */
    public function it_can_update_advisor()
    {
        $advisor = Advisor::factory()->create();
        $newAdvisor = Advisor::factory()->make();

        Livewire::test(EditAdvisor::class, [
            'record' => $advisor->id
        ])
        ->set('data.name', $newAdvisor->name)
        ->set('data.email', $newAdvisor->email)
        ->call('save')
        ->assertHasNoErrors();

        $this->assertDatabaseCount('advisors', 1);
        $this->assertDatabaseHas('advisors', [
            'name' => $newAdvisor->name,
            'email' => $newAdvisor->email,
        ]);
    }

    /** @test */
    public function advisor_update_has_validation()
    {
        $advisor = Advisor::factory()->create();

        Livewire::test(EditAdvisor::class, [
            'record' => $advisor->id
        ])
            ->set('data.name',null)
            ->set('data.email', null)
            ->call('save')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'required',
            ]);

            $this->assertDatabaseCount('advisors', 1);
            $this->assertDatabaseHas('advisors', [
                'name' => $advisor->name,
                'email' => $advisor->email,
            ]);
    }

    /** @test */
    public function email_must_be_unique_when_updating_advisor()
    {
        $advisor1 = Advisor::factory()->create();
        $advisor2 = Advisor::factory()->create();
        $newAdvisor = Advisor::factory()->make(['email' => $advisor1->email]);

        Livewire::test(EditAdvisor::class, [
            'record' => $advisor2->id
        ])
            ->set('data.name', $newAdvisor->name)
            ->set('data.email', $newAdvisor->email)
            ->call('save')
            ->assertHasFormErrors([
                'email' => 'unique',
            ]);

        $this->assertDatabaseCount('advisors', 2);
        $this->assertDatabaseHas('advisors', [
            'name' => $advisor2->name,
            'email' => $advisor2->email,
        ]);
    }

    /** @test */
    public function it_can_delete_advisor()
    {
        $advisor = Advisor::factory()->create();

        $this->assertDatabaseCount('advisors', 1);

        Livewire::test(EditAdvisor::class, [
            'record' => $advisor->id
        ])
            ->callAction(DeleteAction::class);

        $this->assertDatabaseEmpty('advisors');
    }
}
