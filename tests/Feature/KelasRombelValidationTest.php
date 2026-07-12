<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelasRombelValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_rombel_page_renders_without_undefined_index_error(): void
    {
        $user = User::factory()->create();
        Jurusan::factory()->count(2)->create();
        TahunAjaran::factory()->create(['aktif' => true]);

        $response = $this->actingAs($user)->get(route('kelas-rombel.create'));

        $response->assertOk();
    }

    public function test_class_without_any_rombel_is_rejected(): void
    {
        $user = User::factory()->create();
        $jurusan = Jurusan::factory()->create();
        $tahunAjaran = TahunAjaran::factory()->create(['aktif' => true]);

        $response = $this->actingAs($user)
            ->from(route('kelas-rombel.create'))
            ->post(route('kelas-rombel.store'), [
                'jurusan_id' => $jurusan->id,
                'tingkat' => 'X',
                'rombels' => [],
            ]);

        $response->assertSessionHasErrors('rombels');
        $response->assertSessionHas('error');
    }

    public function test_rombel_can_be_deleted_via_destroy_route(): void
    {
        $user = User::factory()->create();
        $jurusan = Jurusan::factory()->create();
        $tahunAjaran = TahunAjaran::factory()->create(['aktif' => true]);

        $kelas = Kelas::factory()->create([
            'jurusan_id' => $jurusan->id,
            'tingkat' => 'X',
        ]);

        $rombel = Rombel::factory()->create([
            'kelas_id' => $kelas->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tingkat' => 1,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('kelas-rombel.destroy', $rombel));

        $response->assertRedirect(route('kelas'));
        $this->assertDatabaseMissing('rombels', ['id' => $rombel->id]);
    }

    public function test_duplicate_rombel_for_same_jurusan_and_level_is_rejected(): void
    {
        $user = User::factory()->create();
        $jurusan = Jurusan::factory()->create();
        $tahunAjaran = TahunAjaran::factory()->create(['aktif' => true]);

        $kelas = Kelas::factory()->create([
            'jurusan_id' => $jurusan->id,
            'tingkat' => 'X',
        ]);

        Rombel::factory()->create([
            'kelas_id' => $kelas->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tingkat' => 1,
        ]);

        $response = $this->actingAs($user)
            ->from(route('kelas-rombel.create'))
            ->post(route('kelas-rombel.store'), [
                'jurusan_id' => $jurusan->id,
                'tingkat' => 'X',
                'rombels' => [
                    [
                        'tahun_ajaran_id' => $tahunAjaran->id,
                        'tingkat' => 1,
                    ],
                ],
            ]);

        $response->assertSessionHasErrors('rombels.0.tingkat');
        $response->assertSessionHas('error');
    }
}
