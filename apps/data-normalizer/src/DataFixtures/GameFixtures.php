<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataSources\Normalizer\Game\GameNormalizerPipeline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private GameNormalizerPipeline $normalizerPipeline;

    public function __construct(GameNormalizerPipeline $normalizerPipeline)
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

    public function getDependencies()
    {
        return [
            GameGroupFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['games'];
    }
}
