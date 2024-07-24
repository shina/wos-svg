<?php

namespace App\Modules\Participation\Services;

/**
 * Combines given categories into all possible combinations using a specified separator.
 *
 * Thanks, ChatGPT :*
 */
class EventCategoryCombiner
{
    /**
     * Combines the provided categories into all possible combinations.
     *
     * @param  int[]  $categories  An array of categories to combine.
     * @return array[] An array of combined category strings.
     */
    public function combineCategoriesArray(array $categories): array
    {
        $result = [];
        $count = count($categories);

        // Loop through each combination length
        for ($i = 1; $i <= $count; $i++) {
            $this->combineRecursive($categories, $result, [], 0, $i);
        }

        return $result;
    }

    /**
     * @return string[]
     */
    public function combineCategoriesString(array $categories, string $separator = '-'): array
    {
        return collect($this->combineCategoriesArray($categories))
            ->map(fn ($group) => implode($separator, $group))
            ->toArray();
    }

    /**
     * Recursively combines categories into the desired length.
     *
     * @param  array  $tokens  An array of category tokens.
     * @param  array  &$result  The resulting array of combined categories.
     * @param  array  $current  The current combination being built.
     * @param  int  $start  The starting index for combination.
     * @param  int  $length  The desired length of combinations.
     */
    private function combineRecursive(array $tokens, array &$result, array $current, int $start, int $length): void
    {
        // Base case: if the current combination length matches the desired length
        if (count($current) === $length) {
            $result[] = $current;

            return;
        }

        // Recursive case: build combinations
        for ($i = $start; $i < count($tokens); $i++) {
            $current[] = $tokens[$i];
            $this->combineRecursive($tokens, $result, $current, $i + 1, $length);
            array_pop($current);
        }
    }
}
