<?php

namespace App\Services;

use App\Models\PageContent;

class PageContentService
{
    /**
     * Get all active content sections for a page, merged with fallbacks.
     */
    public function getPage(string $pageKey): array
    {
        $defaultPage = config("public_pages.{$pageKey}", []);

        $dbSections = PageContent::where('page_key', $pageKey)
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        $merged = [];
        foreach ($defaultPage as $sectionKey => $defaultContent) {
            if ($dbSections->has($sectionKey)) {
                $dbContent = $dbSections->get($sectionKey)->content;
                if (is_array($defaultContent) && is_array($dbContent)) {
                    $merged[$sectionKey] = $this->mergeRecursive($defaultContent, $dbContent);
                } else {
                    $merged[$sectionKey] = $dbContent ?? $defaultContent;
                }
            } else {
                $merged[$sectionKey] = $defaultContent;
            }
        }

        // Add any database sections that are not defined in the default config (if any)
        foreach ($dbSections as $sectionKey => $dbSection) {
            if (!isset($merged[$sectionKey])) {
                $merged[$sectionKey] = $dbSection->content;
            }
        }

        return $merged;
    }

    /**
     * Get a specific active section content, merged with fallback.
     */
    public function getSection(string $pageKey, string $sectionKey): array
    {
        $defaultContent = config("public_pages.{$pageKey}.{$sectionKey}", []);

        $dbSection = PageContent::where('page_key', $pageKey)
            ->where('section_key', $sectionKey)
            ->where('is_active', true)
            ->first();

        if ($dbSection) {
            $dbContent = $dbSection->content;
            if (is_array($defaultContent) && is_array($dbContent)) {
                return $this->mergeRecursive($defaultContent, $dbContent);
            }
            return $dbContent ?? $defaultContent;
        }

        return $defaultContent;
    }

    /**
     * Recursively merge default config settings with database content.
     * Associative arrays are merged, sequential arrays (lists) are overwritten.
     */
    public function mergeRecursive(array $array1, array $array2): array
    {
        $merged = $array1;
        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                if ($this->isAssoc($value)) {
                    $merged[$key] = $this->mergeRecursive($merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    /**
     * Check if array is associative.
     */
    private function isAssoc(array $arr): bool
    {
        if ([] === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
