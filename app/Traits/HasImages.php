<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Psr\Http\Message\StreamInterface;

/**
 * Trait HasImages
 *
 * This trait is used to add image functionality to a model.
 */
trait HasImages
{

    /**
     * Get the images array.
     *
     * @return array
     */
    protected function images(): array
    {
        return $this->images ?? [];
    }

    /**
     * Get the disk for the image.
     *
     * @return string
     */
    protected function imageDisk(): string
    {
        return 'public';
    }

    /**
     * Get the image path.
     *
     * @param  string $key
     * @return string
     */
    protected function getImagePath(string $key): string
    {
        return Arr::get($this->images(), $key, '');
    }

    /**
     * Get the image URL.
     *
     * @param  string $key
     * @return string
     */
    public function getImageUrl(string $key): string
    {
        $path = $this->getImagePath($key);
        return $path ? Storage::disk($this->imageDisk())->url($path) : '';
    }

    /**
     * Make the image path.
     *
     * @param  string $key
     * @param  string $extension
     * @return string
     */
    protected function makeImagePath(string $key, string $extension = 'png'): string
    {
        return sprintf('images/%s/%s/%s.%s', Str::of(static::class)->afterLast('\\')->lower(), $key, Str::uuid7()->toString(), $extension);
    }

    /**
     * Save the image.
     *
     * @param  string                                   $key
     * @param  string|File|StreamInterface|UploadedFile $image
     * @param  string                                   $extension
     * @return static
     */
    public function saveImage(string $key, string|File|StreamInterface|UploadedFile $image, string $extension = 'png'): static
    {
        $path = $this->makeImagePath($key, $extension);
        Storage::disk($this->imageDisk())->put($path, $image);
        $this->images = array_merge($this->images, [$key => $path]);
        return $this;
    }
}
