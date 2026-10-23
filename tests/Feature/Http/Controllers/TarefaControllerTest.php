<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TarefaControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_returns_all_tarefas(): void
    {
        Tarefa::factory()->create([
            'titulo' => 'Primeira tarefa',
        ]);
        Tarefa::factory()->create([
            'titulo' => 'Segunda tarefa',
        ]);

        $response = $this->getJson(route('tarefas.index'));

        $response
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonFragment(['titulo' => 'Primeira tarefa'])
            ->assertJsonFragment(['titulo' => 'Segunda tarefa']);
    }

    public function test_valid_payload_creates_tarefa_and_returns_201(): void
    {
        $payload = [
            'titulo' => 'Preparar apresentação',
            'descricao' => 'Organizar os slides da apresentação.',
            'concluida' => true,
            'deleted_at' => now()->toISOString(),
        ];

        $response = $this->postJson(route('tarefas.store'), $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('titulo', 'Preparar apresentação')
            ->assertJsonPath('descricao', 'Organizar os slides da apresentação.')
            ->assertJsonPath('concluida', true)
            ->assertJsonPath('deleted_at', null);

        $this->assertDatabaseHas('tarefas', [
            'titulo' => 'Preparar apresentação',
            'descricao' => 'Organizar os slides da apresentação.',
            'concluida' => true,
            'deleted_at' => null,
        ]);
    }

    public function test_returns_422_when_required_fields_are_missing(): void
    {
        $response = $this->postJson(route('tarefas.store'));

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['titulo', 'descricao']);
    }

    public function test_returns_requested_tarefa(): void
    {
        $tarefa = Tarefa::factory()->create([
            'titulo' => 'Tarefa encontrada',
        ]);

        $response = $this->getJson(route('tarefas.show', $tarefa));

        $response
            ->assertOk()
            ->assertJsonPath('id', $tarefa->id)
            ->assertJsonPath('titulo', 'Tarefa encontrada');
    }

    public function test_returns_404_when_tarefa_does_not_exist(): void
    {
        $response = $this->getJson(route('tarefas.show', 999));

        $response->assertNotFound();
    }

    public function test_valid_payload_updates_tarefa_and_returns_204(): void
    {
        $tarefa = Tarefa::factory()->create([
            'titulo' => 'Título antigo',
            'descricao' => 'Descrição antiga.',
            'concluida' => false,
        ]);

        $response = $this->putJson(route('tarefas.update', $tarefa), [
            'titulo' => 'Título atualizado',
            'descricao' => 'Descrição atualizada.',
            'concluida' => true,
        ]);

        $response->assertNoContent();

        $this->assertDatabaseHas('tarefas', [
            'id' => $tarefa->id,
            'titulo' => 'Título atualizado',
            'descricao' => 'Descrição atualizada.',
            'concluida' => true,
        ]);
    }

    public function test_deletes_tarefa_and_returns_204(): void
    {
        $tarefa = Tarefa::factory()->create();

        $response = $this->deleteJson(route('tarefas.destroy', $tarefa));

        $response->assertNoContent();

        $this->assertSoftDeleted($tarefa);
    }
}
