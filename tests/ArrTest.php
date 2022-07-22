<?php

namespace POmelchenko\Utils\Tests;

use POmelchenko\Utils\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function testUpdateArrayByAnotherArray(): void
    {
        $arrayA = [
            'id' => 10,
            'bannerName' => 'name10',
            'views' => 10,
        ];

        $arrayB = [
            'id' => 10,
            'clicks' => 3,
        ];

        $result = [
            'id' => 10,
            'bannerName' => 'name10',
            'views' => 10,
            'clicks' => 3,
        ];

        self::assertEquals($result, Arr::updateArrayByAnotherArray($arrayA, $arrayB));
    }

    public function testUpdateArrayByAnotherArrayAndAdditionalDataByFunction(): void
    {
        $arrayA = [
            'id' => 10,
            'bannerName' => 'name10',
            'views' => 10,
        ];

        $arrayB = [
            'id' => 10,
            'clicks' => 3,
        ];

        $additionalData = [
            'ctr' => function($arrayA, $arrayB) {
                return round(($arrayB['clicks'] / $arrayA['views']) * 100, 2);
            },
        ];

        $result = [
            'id' => 10,
            'bannerName' => 'name10',
            'views' => 10,
            'clicks' => 3,
            'ctr' => 30,
        ];

        self::assertEquals($result, Arr::updateArrayByAnotherArray($arrayA, $arrayB, $additionalData));
    }

    public function testUpdateArrayByAnotherArrayAndAdditionalDataByStaticData(): void
    {
        $arrayA = [
            'id' => 10,
            'bannerName' => 'name10',
            'views' => 10,
        ];

        $arrayB = [
            'id' => 10,
            'clicks' => 3,
        ];

        $additionalData = [
            'ctr' => 100500,
        ];

        $result = [
            'id' => 10,
            'bannerName' => 'name10',
            'views' => 10,
            'clicks' => 3,
            'ctr' => 100500,
        ];

        self::assertEquals($result, Arr::updateArrayByAnotherArray($arrayA, $arrayB, $additionalData));
    }

    public function testMakePKForCollection(): void
    {
        $array = [
            [
                'id' => 14,
                'clicks' => 2,
            ],
            [
                'id' => 10,
                'clicks' => 3,
            ],
        ];

        $result = [
            'id_14' => [
                'id' => 14,
                'clicks' => 2,
            ],
            'id_10' => [
                'id' => '10',
                'clicks' => 3,
            ],
        ];

        self::assertEquals($result, Arr::makePKForCollection($array, 'id', '_'));
    }

    public function testUpdateCollectionByAnotherCollection(): void
    {
        $collectionA = [
            [
                'id' => 14,
                'bannerName' => 'name14',
                'views' => 8,
            ],
            [
                'id' => 10,
                'bannerName' => 'name10',
                'views' => 10,
            ],
        ];

        $collectionB = [
            [
                'id' => 14,
                'clicks' => 2,
            ],
            [
                'id' => 10,
                'clicks' => 3,
            ],
        ];

        $result = [
            [
                'id' => 14,
                'bannerName' => 'name14',
                'views' => 8,
                'clicks' => 2,
            ],
            [
                'id' => 10,
                'bannerName' => 'name10',
                'views' => 10,
                'clicks' => 3,
            ],
        ];

        self::assertEquals($result, Arr::updateCollectionByAnotherCollection($collectionA, $collectionB, 'id'));
    }

    public function testUpdateCollectionByAnotherCollectionAndNotFullMathByPK(): void
    {
        $collectionA = [
            [
                'id' => 8,
                'bannerName' => 'name8',
                'views' => 5,
            ],
            [
                'id' => 14,
                'bannerName' => 'name14',
                'views' => 8,
            ],
            [
                'id' => 10,
                'bannerName' => 'name10',
                'views' => 10,
            ],
        ];

        $collectionB = [
            [
                'id' => 14,
                'clicks' => 2,
            ],
            [
                'id' => 10,
                'clicks' => 3,
            ],
        ];

        $default = [
            'clicks' => 0,
        ];

        $additionalData = [
            'ctr' => function($itemFromCollectionA, $itemFromCollectionB) {
                return round(($itemFromCollectionB['clicks'] / $itemFromCollectionA['views']) * 100, 2);
            },
        ];

        $result = [
            [
                'id' => 8,
                'bannerName' => 'name8',
                'views' => 5,
                'clicks' => 0,
                'ctr' => 0,
            ],
            [
                'id' => 14,
                'bannerName' => 'name14',
                'views' => 8,
                'clicks' => 2,
                'ctr' => 25,
            ],
            [
                'id' => 10,
                'bannerName' => 'name10',
                'views' => 10,
                'clicks' => 3,
                'ctr' => 30,
            ],
        ];

        self::assertEquals($result, Arr::updateCollectionByAnotherCollection(
            $collectionA,
            $collectionB,
            'id',
            $default,
            $additionalData,
        ));
    }
}
