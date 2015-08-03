<?php

namespace Behat\Borg\Integration\Release\Composer;

use Behat\Borg\Integration\Release\Composer\Exception\AuthorNameIsNotDefined;

/**
 * Represents individual package author from composer.json
 */
final class Author
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
     * Initializes author from the composer array.
     *
     * @param array $unserializedComposerAuthor
     *
     * @return Author
     *
     * @throws AuthorNameIsNotDefined
     */
    public static function fromArray(array $unserializedComposerAuthor)
    {
        if (!isset($unserializedComposerAuthor['name'])) {
            throw new AuthorNameIsNotDefined('Composer authors should have a name.');
        }

        $author = new Author(
            $unserializedComposerAuthor['name'],
            isset($unserializedComposerAuthor['email']) ? $unserializedComposerAuthor['email'] : null
        );

        return $author;
    }

    /**
     * Initializes author.
     *
     * @param string $name
     * @param string $email
     */
    public function __construct($name, $email = null)
    {
        $this->name = $name;
        $this->email = $email;
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
