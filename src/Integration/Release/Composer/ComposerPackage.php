<?php

namespace Behat\Borg\Integration\Release\Composer;

use Behat\Borg\Release\Exception\BadPackageNameGiven;
use Behat\Borg\Release\Package;

/**
 * composer.json-based package.
 */
final class ComposerPackage implements Package
{
    const DEFAULT_TYPE = 'library';

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $description;
    /**
     * @var array
     */
    private $authors;

    /**
     * Initializes package.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $name = $data['name'];

        if (1 !== preg_match(self::PACKAGE_NAME_REGEX, $name)) {
            throw new BadPackageNameGiven(
                "Composer package name should match `" . self::PACKAGE_NAME_REGEX . "`, but `{$name}` given."
            );
        }

        $this->name = strtolower($name);
        $this->type = $this->extractType($data);
        $this->description = $this->extractDescription($data);
        $this->authors = $this->extractAuthors($data);
    }

    /**
     * {@inheritdoc]
     */
    public function organisationName()
    {
        return explode('/', $this->name)[0];
    }

    /**
     * {@inheritdoc]
     */
    public function name()
    {
        return explode('/', $this->name)[1];
    }

    /**
     * Returns composer package type.
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Returns package description.
     *
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Hash of the primary package author or null if no authors defined.
     *
     * @return Author|null
     */
    public function primaryAuthor()
    {
        return count($this->authors) ? current($this->authors) : null;
    }

    /**
     * Returns package authors.
     *
     * @return Author[]
     */
    public function authors()
    {
        return $this->authors;
    }

    /**
     * {@inheritdoc]
     */
    public function __toString()
    {
        return $this->name;
    }

    private function extractType(array $data)
    {
        return isset($data['type']) ? $data['type'] : self::DEFAULT_TYPE;
    }

    private function extractDescription(array $data)
    {
        return isset($data['description']) ? $data['description'] : null;
    }

    private function extractAuthors(array $data)
    {
        if (!isset($data['authors'])) {
            return [];
        }

        return array_map([$this, 'extractAuthor'], $data['authors']);
    }

    private function extractAuthor(array $author)
    {
        return Author::fromArray($author);
    }
}
