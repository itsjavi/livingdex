<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataSources\Normalizer\Ability\AbilityNormalizerPipeline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AbilityFixtures extends Fixture implements FixtureGroupInterface
{
    private AbilityNormalizerPipeline $normalizerPipeline;

    public function __construct(AbilityNormalizerPipeline $normalizerPipeline)
    {
        $this->normalizerPipeline = $normalizerPipeline;
    }

    public function load(ObjectManager $manager)
    {
        $dataset = $this->normalizerPipeline->normalize();

        foreach ($dataset as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['abilities'];
    }
}
