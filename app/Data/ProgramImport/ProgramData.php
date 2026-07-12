<?php

namespace App\Data\ProgramImport;

/**
 * One parsed "## ITEM" record from tours-data.md.
 */
class ProgramData
{
    /**
     * @param  list<string>  $highlights
     * @param  list<string>  $included
     * @param  list<string>  $excluded
     * @param  list<string>  $itinerary
     * @param  list<string>  $languages
     * @param  list<string>  $matchEvidence
     */
    public function __construct(
        public readonly int $index,
        public readonly string $section,
        public readonly ?string $type,
        public readonly string $title,
        public readonly string $category,
        public readonly string $location,
        public readonly string $overview,
        public readonly array $highlights,
        public readonly string $duration,
        public readonly string $groupSize,
        public readonly string $ageRange,
        public readonly string $basePrice,
        public readonly array $languages,
        public readonly array $included,
        public readonly array $excluded,
        public readonly array $itinerary,
        public readonly bool $bestseller,
        public readonly bool $freeCancellation,
        public readonly ?string $mapFrame,
        public readonly ?ProgramImageData $cover,
        public readonly ?ProgramImageData $gallery,
        public readonly string $matchStatus,
        public readonly float $matchConfidence,
        public readonly array $matchEvidence,
        public readonly ?string $matchReviewNotes,
        /** @var list<array{day: int, title: string, description: string}> */
        public readonly array $itineraryDetails = [],
    ) {}

    /** A record is "matched" when it has at least a cover; gallery is optional. */
    public function hasImages(): bool
    {
        return $this->cover !== null;
    }
}
