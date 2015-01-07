Feature: Current documentation is available
  In order to help newcomers not get lost in multiple versions of the framework
  As a documentation contributor
  I want latest most stable version of documentation to be available as current

  Rules:
  - Use the latest stable release (v2.0.1) if there are some
  - If there are no stable releases, but there are some dev releases (v2.0.x) - use the latest
  - If there are no stable or dev releases, then use branches in this order: master, develop

  Scenario: Having some stable versions published
    Given "behat/symfony2-extension" version "v2.0.0" was documented in "Behat/Symfony2Extension"
    And "behat/symfony2-extension" version "master" was documented in "Behat/Symfony2Extension"
    And "behat/symfony2-extension" version "v1.1.2" was documented in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    And I release "Behat/Symfony2Extension" version "master"
    And I release "Behat/Symfony2Extension" version "v1.1.2"
    Then current "behat/symfony2-extension" documentation should point to version "v2.0.0"

  Scenario: Having dev versions published
    Given "behat/behat" version "v3.0" was documented in "Behat/docs"
    And "behat/behat" version "master" was documented in "Behat/docs"
    And "behat/behat" version "v2.5" was documented in "Behat/docs"
    When I release "Behat/docs" version "v2.5"
    And I release "Behat/docs" version "v3.0"
    And I release "Behat/docs" version "master"
    Then current "behat/behat" documentation should point to version "v3.0.x"

  Scenario: Having only branch versions published
    Given "behat/behat" version "master" was documented in "Behat/docs"
    And "behat/behat" version "develop" was documented in "Behat/docs"
    When I release "Behat/docs" version "master"
    And I release "Behat/docs" version "develop"
    Then current "behat/behat" documentation should point to version "develop"
