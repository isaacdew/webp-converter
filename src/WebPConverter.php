<?php

namespace Isaacdew\WebPConverter;

class WebPConverter {

    protected string $extension;

    public function __construct(
        protected string $src,
        protected string $destination,
        protected int $quality
    )
    {
        if(!function_exists('imagewebp')) throw new WebPConverterException('WebP support is not enabled in PHP!');
        $this->extension = pathinfo($this->src, PATHINFO_EXTENSION);

        $this->handle();
    }

    public static function convert(string $src, string $destination = '', int $quality = 100) {
        return new static($src, $destination, $quality);
    }

    protected function handle() {
        $image = $this->createImageResource();

        if(!$image) throw new WebPConverterException('Failed to create image resource');

        if(empty($this->destination)) {
            $this->destination = $this->createDestination();
        }

        imagewebp($image, $this->destination, $this->quality);
        imagedestroy($image);
    }

    protected function createImageResource() {
        
        if($this->extension === 'jpg' || $this->extension === 'jpeg') return imagecreatefromjpeg($this->src);
        if($this->extension === 'png') return imagecreatefrompng($this->src);
        if($this->extension === 'gif') return imagecreatefromgif($this->src);

        return false;
    }

    protected function createDestination() {
        return preg_replace('/\.' . $this->extension . '$/', '.webp', $this->src);
    }

    public function getDestination() {
        return $this->__toString();
    }

    public function __toString()
    {
        return $this->destination;
    }
}
