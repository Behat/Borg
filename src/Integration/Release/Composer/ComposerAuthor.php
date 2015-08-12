<?php

namespace Behat\Borg\Integration\Release\Composer;

use Behat\Borg\Integration\Release\Composer\Exception\AuthorNameIsNotDefined;

/**
 * Represents individual package author from composer.json
 */
final class ComposerAuthor
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var null|string
     */
    private $email;

    /**
     * Initializes author from the composer authors meta.
     *
     * @param array $meta
     *
     * @return ComposerAuthor
     *
     * @throws AuthorNameIsNotDefined
     */
    public function __construct(array $meta)
    {
        if (!isset($meta['name'])) {
            throw new AuthorNameIsNotDefined('Composer authors should have a name.');
        }

        $this->name = $meta['name'];
        $this->email = isset($meta['email']) ? $meta['email'] : null;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function email()
    {
        return $this->email;
    }
}
