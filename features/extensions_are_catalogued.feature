Feature: Extensions are catalogued
  In order to help advanced users fine-tune behat to their needs
  As an extension maintainer
  I want my extensions to be catalogued when I release a new versions of them

  Rules:
  - Extension release causes extension to be added to the extension catalogue

  Scenario: Releasing a stable extension
    Given "behat/symfony2-extension" extension was created in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    Then extension catalogue should contain 1 extension
    And "behat/symfony2-extension" extension should be in it

  Scenario: Releasing multiple stable extensions
    Given "behat/symfony2-extension" extension was created in "Behat/Symfony2Extension"
    And "behat/mink-extension" extension was created in "Behat/MinkExtension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    And I release "Behat/MinkExtension" version "v2.0.1"
    Then extension catalogue should contain 2 extensions

  Scenario: Releasing multiple versions of the same extension
    Given "behat/mink-extension" extension was created in "Behat/MinkExtension"
    When I release "Behat/MinkExtension" version "v2.0.0"
    And I release "Behat/MinkExtension" version "v2.0.1"
    Then extension catalogue should still contain 1 extension
