<?php

namespace App\Data\ProgramImport;

/**
 * One image entry (cover or gallery item) from a tours-data.md images block.
 */
class ProgramImageData
{
    public function __construct(
        public readonly string $path,
        public readonly string $filename,
        public readonly string $alt,
        public readonly string $title,
        public readonly string $caption,
        public readonly string $description,
        public readonly ?int $width,
        public readonly ?int $height,
        public readonly ?int $sizeBytes,
        public readonly string $sha256,
        public readonly ?string $sourceWarning,
        public readonly bool $replacementRecommended,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            path: (string) ($data['path'] ?? ''),
            filename: (string) ($data['filename'] ?? ''),
            alt: (string) ($data['alt'] ?? ''),
            title: (string) ($data['title'] ?? ''),
            caption: (string) ($data['caption'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            width: isset($data['width']) ? (int) $data['width'] : null,
            height: isset($data['height']) ? (int) $data['height'] : null,
            sizeBytes: isset($data['size_bytes']) ? (int) $data['size_bytes'] : null,
            sha256: (string) ($data['sha256'] ?? ''),
            sourceWarning: $data['source_warning'] ?? null,
            replacementRecommended: ($data['replacement_recommended'] ?? false) === true,
        );
    }
}
