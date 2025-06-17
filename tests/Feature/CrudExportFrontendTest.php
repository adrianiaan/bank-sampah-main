<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Jenis_sampah;
use App\Models\Penjemputan;
use App\Models\Transaksi;
use App\Models\Saldo;

class CrudExportFrontendTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a super admin user for authentication
        $this->superAdmin = User::factory()->create([
            'role' => 'super_admin',
        ]);
    }

    /** @test */
    public function test_crud_jenis_sampah()
    {
        $this->actingAs($this->superAdmin);

        // Create
        $response = $this->post(route('jenis_sampah.store'), [
            'name' => 'Plastik',
            'kategori' => 'Sampah Kering',
            'harga' => 500,
            'deskripsi' => 'Sampah plastik',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('jenis_sampahs', ['name' => 'Plastik']);

        $jenis = Jenis_sampah::where('name', 'Plastik')->first();

        // Update
        $response = $this->put(route('jenis_sampah.update', $jenis->id), [
            'name' => 'Plastik Updated',
            'kategori' => 'Sampah Kering',
            'harga' => 600,
            'deskripsi' => 'Sampah plastik updated',
        ]);
        $response->assertRedirect(route('jenis_sampah.index'));
        $this->assertDatabaseHas('jenis_sampahs', ['name' => 'Plastik Updated']);

        // Delete
        $response = $this->delete(route('jenis_sampah.destroy', $jenis->id));
        $response->assertRedirect(route('jenis_sampah.index'));
        $this->assertDatabaseMissing('jenis_sampahs', ['name' => 'Plastik Updated']);
    }

    /** @test */
    public function test_crud_user_management()
    {
        $this->actingAs($this->superAdmin);

        // Create
        $response = $this->post(route('user_management.store'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'role' => 'end_user',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);

        $user = User::where('email', 'testuser@example.com')->first();

        // Update
        $response = $this->put(route('user_management.update', $user->id), [
            'name' => 'Test User Updated',
            'email' => 'testuser@example.com',
            'role' => 'end_user',
        ]);
        $response->assertRedirect(route('user_management.index'));
        $this->assertDatabaseHas('users', ['name' => 'Test User Updated']);

        // Delete
        $response = $this->delete(route('user_management.destroy', $user->id));
        $response->assertRedirect(route('user_management.index'));
        $this->assertDatabaseMissing('users', ['email' => 'testuser@example.com']);
    }

    /** @test */
    public function test_crud_penjemputan()
    {
        $this->actingAs($this->superAdmin);

        // Create
        $response = $this->post(route('penjemputan.store'), [
            'tanggal' => now()->toDateString(),
            'alamat' => 'Jl. Contoh No.1',
            'status' => 'pending',
        ]);
        $response->assertRedirect(route('penjemputan.index'));
        $this->assertDatabaseHas('penjemputans', ['alamat' => 'Jl. Contoh No.1']);

        $penjemputan = Penjemputan::where('alamat', 'Jl. Contoh No.1')->first();

        // Update
        $response = $this->put(route('penjemputan.update', $penjemputan->id), [
            'tanggal' => now()->addDay()->toDateString(),
            'alamat' => 'Jl. Contoh No.2',
            'status' => 'completed',
        ]);
        $response->assertRedirect(route('penjemputan.index'));
        $this->assertDatabaseHas('penjemputans', ['alamat' => 'Jl. Contoh No.2']);

        // Delete
        $response = $this->delete(route('penjemputan.destroy', $penjemputan->id));
        $response->assertRedirect(route('penjemputan.index'));
        $this->assertDatabaseMissing('penjemputans', ['alamat' => 'Jl. Contoh No.2']);
    }

    /** @test */
    public function test_crud_transaksi()
    {
        $this->actingAs($this->superAdmin);

        $user = User::factory()->create(['role' => 'end_user']);
        $jenis = Jenis_sampah::factory()->create();

        // Create
        $response = $this->post(route('transaksi.store'), [
            'user_id' => $user->id,
            'jenis_sampah_id' => $jenis->id,
            'berat' => 10,
            'status' => 'pending',
        ]);
        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('transaksis', ['user_id' => $user->id]);

        $transaksi = Transaksi::where('user_id', $user->id)->first();

        // Update
        $response = $this->put(route('transaksi.update', $transaksi->id), [
            'user_id' => $user->id,
            'jenis_sampah_id' => $jenis->id,
            'berat' => 15,
            'status' => 'completed',
        ]);
        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('transaksis', ['berat' => 15]);

        // Delete
        $response = $this->delete(route('transaksi.destroy', $transaksi->id));
        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseMissing('transaksis', ['id' => $transaksi->id]);
    }

    /** @test */
    public function test_crud_saldo()
    {
        $this->actingAs($this->superAdmin);

        $user = User::factory()->create(['role' => 'end_user']);

        // Create Saldo
        $response = $this->post(route('saldo.store'), [
            'user_id' => $user->id,
            'jumlah_saldo' => 100000,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('saldos', ['user_id' => $user->id]);

        $saldo = Saldo::where('user_id', $user->id)->first();

        // Update Saldo
        $response = $this->put(route('saldo.update', $saldo->id), [
            'jumlah_saldo' => 150000,
        ]);
        $response->assertRedirect(route('saldo.index'));
        $this->assertDatabaseHas('saldos', ['jumlah_saldo' => 150000]);

        // Delete Saldo
        $response = $this->delete(route('saldo.destroy', $saldo->id));
        $response->assertRedirect(route('saldo.index'));
        $this->assertDatabaseMissing('saldos', ['id' => $saldo->id]);
    }

    /** @test */
    public function test_export_and_pdf_generation()
    {
        $this->actingAs($this->superAdmin);

        // Test export user management PDF
        $response = $this->get(route('user_management.cetakPDF'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        // Test export jenis sampah PDF
        $response = $this->get(route('jenis_sampah.cetakPDF'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        // Test export penjemputan PDF
        $response = $this->get(route('penjemputan.cetakPDF'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        // Test export transaksi PDF
        $response = $this->get(route('transaksi.cetakPDF'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        // Test export saldo PDF
        $response = $this->get(route('saldo.cetakManajemenPDF'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function test_frontend_interactions()
    {
        $this->actingAs($this->superAdmin);

        // Test user management AJAX form submit
        $response = $this->postJson(route('user_management.store'), [
            'name' => 'Ajax User',
            'email' => 'ajaxuser@example.com',
            'password' => 'password',
            'role' => 'end_user',
        ]);
        $response->assertJson(['status' => 1]);

        // Test datatable visibility for super_admin
        $response = $this->get(route('user_management.index'));
        $response->assertSee('Ajax User');
    }
}
