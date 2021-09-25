<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataSources\Normalizer\GameGroup\GameGroupNormalizerPipeline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class GameGroupFixtures extends Fixture implements FixtureGroupInterface
{
    private GameGroupNormalizerPipeline $normalizerPipeline;

    public function __construct(GameGroupNormalizerPipeline $normalizerPipeline)
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
        return ['games'];
    }
}
