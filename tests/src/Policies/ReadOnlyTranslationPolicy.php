<?php

namespace TomatoPHP\FilamentTranslations\Tests\Policies;

/**
 * Lets the user browse translations but not change them.
 */
class ReadOnlyTranslationPolicy
{
    public function viewAny($user): bool
    {
        return true;
    }

    public function view($user, $translation): bool
    {
        return true;
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
