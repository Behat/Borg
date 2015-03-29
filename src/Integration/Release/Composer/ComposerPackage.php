<?php

namespace Behat\Borg\Integration\Release\Composer;

use Behat\Borg\Release\Exception\BadPackageNameGiven;
use Behat\Borg\Release\Package;

/**
 * composer.json-based package.
 */
final class ComposerPackage implements Package
{
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
        $this->type = $data['type'];
        $this->description = isset($data['description']) ? $data['description'] : null;
        $this->authors = isset($data['authors']) ? $data['authors'] : [];
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
     * @return array|null
     */
    public function primaryAuthor()
    {
        return count($this->authors) ? $this->authors[0] : null;
    }

    /**
     * Returns package authors.
     *
     * @return array
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
}
