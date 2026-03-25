<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadServiceTest extends TestCase
{
    private ImageUploadService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ImageUploadService();
    }

    /** @test */
    public function it_can_upload_an_image_successfully()
    {
        // On demande à Laravel de simuler le disque public
        Storage::fake('public');

        // On crée une fausse image pour le test
        $file = UploadedFile::fake()->image('chemise.jpg');

        // On exécute le service
        $path = $this->service->uploadClothingImage($file);

        // On vérifie qu'un chemin est retourné et qu'il commence bien par 'clothes/'
        $this->assertNotNull($path);
        $this->assertStringStartsWith('clothes/', $path);

        // On vérifie que le fichier a bien été simulé sur le disque public
        Storage::disk('public')->assertExists($path);
    }

    /** @test */
    public function it_returns_null_if_no_image_is_provided()
    {
        $path = $this->service->uploadClothingImage(null);

        $this->assertNull($path);
    }

    /** @test */
    public function it_can_delete_an_existing_image()
    {
        Storage::fake('public');
        
        // On simule un fichier déjà présent sur le disque
        $fakePath = 'clothes/fake_image_from_test.jpg';
        Storage::disk('public')->put($fakePath, 'contenu fantome');

        $this->assertTrue(Storage::disk('public')->exists($fakePath));

        // On teste la suppression via le service
        $deleted = $this->service->deleteImage($fakePath);

        $this->assertTrue($deleted);
        $this->assertFalse(Storage::disk('public')->exists($fakePath));
    }
}
