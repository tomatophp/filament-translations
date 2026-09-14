<?php

namespace TomatoPHP\FilamentTranslations\Tests\Policies;

/**
 * Denies everything, including listing translations.
 */
class DenyingTranslationPolicy
{
    public function viewAny($user): bool
    {
        return false;
    }

    public function view($user, $translation): bool
    {
        return false;
    }

    public function create($user): bool
    {
        return false;
    }

    public function update($user, $translation): bool
    {
        return false;
    }

    public function delete($user, $translation): bool
    {
        return false;
    }

    public function deleteAny($user): bool
    {
        return false;
    }
}
