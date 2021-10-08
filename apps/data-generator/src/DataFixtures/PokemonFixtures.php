<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataSources\Normalizer\Pokemon\PokemonContainer;
use App\DataSources\Normalizer\Pokemon\PokemonNormalizerPipeline;
use App\Entity\LivingDex\Pokemon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PokemonFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private PokemonNormalizerPipeline $normalizerPipeline;

    public function __construct(PokemonNormalizerPipeline $normalizerPipeline)
    {
        $this->normalizerPipeline = $normalizerPipeline;
    }

    public function load(ObjectManager $manager)
    {
        /** @var PokemonContainer[] $dataset */
        $dataset = $this->normalizerPipeline->normalize();

        foreach ($dataset as $id => $container) {
            $entity = $container->getEntity();

            // echo "{$entity->getSlug()} - {$entity->getId()} / {$entity->getDexNum()} \n";
            $manager->persist($entity);

            if ($entity->getBaseSpecies()) {
                $manager->persist($entity->getBaseSpecies());
            }

            // add and persist data
            $data = $container->getData();
            if ($data !== null) {
                $entity->addData($data);
                $manager->persist($data);
            }

            // add and persist GO data
            $dataGo = $container->getDataGo();
            if ($dataGo !== null) {
                $entity->addDataGo($dataGo);
                $manager->persist($dataGo);
            }

            // add and persist forms data
//            foreach ($entity->getForms() as $form) {
//                $manager->persist($form);
//            }

            $manager->flush();
        }
        $manager->flush();
        $manager->clear();
    }

    public function getDependencies()
    {
        return [
            AbilityFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['pokemon'];
    }
}
