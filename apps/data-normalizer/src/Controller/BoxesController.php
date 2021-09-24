<?php

namespace App\Controller;

use App\DataSources\DataSourceFileIo;
use App\Entity\LivingDex\Pokemon;
use App\Support\BoxPositionCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoxesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private BoxPositionCalculator $gridPositionCalculator;
    private DataSourceFileIo $localDataSource;

    public function __construct(
        EntityManagerInterface $entityManager,
        BoxPositionCalculator $gridPositionCalculator,
        DataSourceFileIo $dataListFileReader
    ) {
        $this->entityManager = $entityManager;
        $this->gridPositionCalculator = $gridPositionCalculator;
        $this->localDataSource = $dataListFileReader;
    }

    /**
     * @Route("/boxes", name="boxes")
     */
    public function index(Request $request): Response
    {
        $cellSize = $request->get('size', 64);
        $boxGroup = $request->get('group', 'all');

        $pokemonList = $this->entityManager
            ->getRepository(Pokemon::class)
            ->createQueryBuilder('p')
            ->andWhere('p.isHomeStorable = 1')
            ->andWhere('p.isGmax = 0')
            ->orderBy('p.dexNum, p.sortingOrder')
            ->getQuery()
            ->getResult();

        /** @var Pokemon[][] $pokemonBoxes */
        $pokemonBoxes = [];
        $pokemonBoxGroups = [
            'home'       => [
                'title'       => 'Regular HOME Renders',
                'imgPath'     => 'img/home-renders/pokemon/regular/',
                'imgProperty' => 'imgHome',
            ],
            'home_shiny' => [
                'title'       => 'Shiny HOME Renders',
                'imgPath'     => 'img/home-renders/pokemon/shiny/',
                'imgProperty' => 'imgHome',
            ],
            'icon'       => [
                'title'       => 'Regular Menu Icons',
                'imgPath'     => 'img/menu-sprites/regular/',
                'imgProperty' => 'imgSprite',
            ],
            'icon_shiny' => [
                'title'       => 'Shiny Menu Icons',
                'imgPath'     => 'img/menu-sprites/shiny/',
                'imgProperty' => 'imgSprite',
            ],
        ];

        if ($boxGroup !== 'all' && isset($pokemonBoxGroups[$boxGroup])) {
            $pokemonBoxGroups = [$boxGroup => $pokemonBoxGroups[$boxGroup]];
        }

        $cellPadding = 0;
        $boxTitleHeight = 24;
        $boxTitlePadding = 8;
        $boxTitleMarginBottom = 10;
        $boxWidth = ($cellSize + $cellPadding) * 6;
        $boxHeight = (($cellSize + $cellPadding) * 5) + ($boxTitleHeight + ($boxTitlePadding * 2) + $boxTitleMarginBottom);
        $boxMargin = 30;
        $boxBorder = 1;
        $boxPadding = 5;
        $spriteHeight = $cellSize - 8;
        $boxOuterWidth = $boxWidth + $boxMargin + ($boxBorder * 2) + ($boxPadding * 2);
        $boxesPerGroupRow = 4;

        do {
            $wrapperWidth = ($boxOuterWidth * $boxesPerGroupRow) - $boxMargin;
            $boxesPerGroupRow--;
            if ($boxesPerGroupRow <= 0) {
                break;
            }
        } while ($wrapperWidth > 1400);

        /**
         * @var Pokemon $poke
         */
        foreach ($pokemonList as $i => $poke) {
            $box = $this->gridPositionCalculator->calculate($i);
            $pokemonBoxes[$box['grid']][$box['row']][$box['column']] = $poke;
        }

        return $this->render(
            'boxes/index.html.twig',
            [
                'style'            => [
                    'cellSize'             => $cellSize . 'px',
                    'cellPadding'          => $cellPadding . 'px',
                    'boxTitleHeight'       => $boxTitleHeight . 'px',
                    'boxTitlePadding'      => $boxTitlePadding . 'px',
                    'boxTitleMarginBottom' => $boxTitleMarginBottom . 'px',
                    'boxPadding'           => $boxPadding . 'px',
                    'boxBorder'            => $boxBorder . 'px solid #11b2b0',
                    'boxWidth'             => $boxWidth . 'px',
                    'boxHeight'            => $boxHeight . 'px',
                    'boxMargin'            => $boxMargin . 'px',
                    'halfBoxMargin'        => ((int)($boxMargin / 2)) . 'px',
                    'spriteWidth'          => 'auto',
                    'wrapperWidth'         => $wrapperWidth . 'px',
                    'spriteHeight'         => $spriteHeight . 'px',
                ],
                'pokemonBoxes'     => $pokemonBoxes,
                'pokemonBoxGroups' => $pokemonBoxGroups,
            ]
        );
    }
}
