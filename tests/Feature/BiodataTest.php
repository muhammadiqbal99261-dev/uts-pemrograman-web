<?php

use App\Models\Biodata;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function fakePngUpload(string $filename): UploadedFile
{
    $pngBinary = base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=',
        true
    );

    return UploadedFile::fake()->createWithContent($filename, is_string($pngBinary) ? $pngBinary : '');
}

test('halaman utama menampilkan navbar, kartu biodata, dan footer', function () {
    Biodata::create([
        'nama' => 'iqbal',
        'deskripsi' => '24010110190 merupakan master dari uts ini dengan tugas membuat front-end dan mengirimkannya ke grup',
        'foto' => 'images/avatar-1.svg',
    ]);

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('UTS Pem Web')
        ->assertSee('iqbal dan davi')
        ->assertSee('24010110190 / 24010110214')
        ->assertSee('iqbal')
        ->assertSee('24010110190 merupakan master dari uts ini')
        ->assertSee('Team iqbal dan davi');
});

test('halaman tim dan tentang dapat diakses tanpa error', function () {
    $this->get(route('uts'))
        ->assertOk()
        ->assertSee('iqbal')
        ->assertSee('davi');

    $this->get(route('tentang'))
        ->assertOk();
});

test('dapat menambahkan biodata baru beserta foto', function () {
    Storage::fake('public');

    $file = fakePngUpload('anggota.png');

    $response = $this->post(route('biodata.store'), [
        'nama' => 'davi',
        'deskripsi' => 'dengan NIM 24010110214 merupakan pegawai dan mempunyai tugas mengerjakan back-end pada UTS ini',
        'foto' => $file,
    ]);

    $response->assertRedirect(route('home'))
        ->assertSessionHas('success', 'Biodata berhasil ditambahkan.');

    $biodata = Biodata::query()->firstWhere('nama', 'davi');
    expect($biodata)->not->toBeNull();
    expect($biodata->foto)->not->toBeNull();
    Storage::disk('public')->assertExists((string) $biodata->foto);
});

test('dapat memperbarui biodata yang ada', function () {
    Storage::fake('public');

    $oldFile = fakePngUpload('lama.png');
    $oldPath = Storage::disk('public')->putFile('biodata', $oldFile);

    $biodata = Biodata::create([
        'nama' => 'nama lama',
        'deskripsi' => 'deskripsi lama',
        'foto' => is_string($oldPath) ? $oldPath : null,
    ]);

    $newFile = fakePngUpload('baru.png');

    $response = $this->put(route('biodata.update', $biodata), [
        'nama' => 'nama baru',
        'deskripsi' => 'deskripsi baru yang diperbarui',
        'foto' => $newFile,
    ]);

    $response->assertRedirect(route('home'))
        ->assertSessionHas('success', 'Biodata berhasil diperbarui.');

    $biodata->refresh();
    expect($biodata->nama)->toBe('nama baru');
    expect($biodata->deskripsi)->toBe('deskripsi baru yang diperbarui');
    Storage::disk('public')->assertMissing((string) $oldPath);
    Storage::disk('public')->assertExists((string) $biodata->foto);
});

test('dapat menghapus biodata dan fotonya', function () {
    Storage::fake('public');

    $file = fakePngUpload('hapus.png');
    $path = Storage::disk('public')->putFile('biodata', $file);

    $biodata = Biodata::create([
        'nama' => 'akan dihapus',
        'deskripsi' => 'deskripsi sementara',
        'foto' => is_string($path) ? $path : null,
    ]);

    $response = $this->delete(route('biodata.destroy', $biodata));

    $response->assertRedirect(route('home'))
        ->assertSessionHas('success', 'Biodata berhasil dihapus.');

    expect(Biodata::find($biodata->id))->toBeNull();
    Storage::disk('public')->assertMissing((string) $path);
});

test('validasi gagal jika nama atau deskripsi kosong', function () {
    $response = $this->from(route('home'))->post(route('biodata.store'), [
        'nama' => '',
        'deskripsi' => '',
    ]);

    $response->assertRedirect(route('home'))
        ->assertSessionHasErrors(['nama', 'deskripsi']);
});
