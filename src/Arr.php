<?php

namespace POmelchenko\Utils;

class Arr
{
    public static function updateArrayByAnotherArray(
        array $willBeUpdated,
        array $withDataFromArray,
        array $additionalData = [],
    ): array {
        $result = [
            ...$willBeUpdated,
            ...$withDataFromArray,
        ];

        if ([] !== $additionalData) {
            foreach ($additionalData as $key => $value) {
                $result[$key] = $value($willBeUpdated, $withDataFromArray);
            }
        }

        return $result;
    }

    public static function makePKForCollection(array $collection, string $pk, string $glue = ''): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[implode($glue, [$pk, $item[$pk]])] = $item;
        }

        return $result;
    }

    public static function updateCollectionByAnotherCollection(
        array $willBeUpdated,
        array $withDataFromCollection,
        string $by,
        array $defaultDataForUpdate = [],
        array $additionalFieldsWithData = [],
    ): array {
        $willBeUpdated = self::makePKForCollection($willBeUpdated, $by);
        $withDataFromCollection = self::makePKForCollection($withDataFromCollection, $by);

        $result = [];

        foreach (array_keys($willBeUpdated) as $key) {
            $result[] = self::updateArrayByAnotherArray(
                $willBeUpdated[$key],
                $withDataFromCollection[$key] ?? $defaultDataForUpdate,
                $additionalFieldsWithData,
            );
        }

        return $result;
    }
}