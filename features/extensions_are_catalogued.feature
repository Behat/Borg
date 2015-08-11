Feature: Extensions are catalogued
  In order to help advanced users fine-tune behat to their needs
  As an extension maintainer
  I want my extensions to be catalogued when I release a new versions of them

  Rules:
    - Extension repository release causes extension to be added to the extension catalogue
    - If repository has no extensions, releasing it doesn't change the catalogue
    - If repository has documentation, but no extensions, releasing it still doesn't change the catalogue

  @critical
  Scenario: Releasing a stable extension
    Given "behat/symfony2-extension" extension package was created in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    Then the extension catalogue should contain 1 extension
    And "behat/symfony2-extension" extension should be in the catalogue

  @critical
  Scenario: Releasing multiple stable extensions
    Given "behat/symfony2-extension" extension package was created in "Behat/Symfony2Extension"
    And "behat/mink-extension" extension package was created in "Behat/MinkExtension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    And I release "Behat/MinkExtension" version "v2.0.1"
    Then the extension catalogue should contain 2 extensions

  Scenario: Releasing multiple versions of the same extension
    Given "behat/mink-extension" extension package was created in "Behat/MinkExtension"
    When I release "Behat/MinkExtension" version "v2.0.0"
    And I release "Behat/MinkExtension" version "v2.0.1"
    Then the extension catalogue should still contain 1 extension

  Scenario: Releasing repository that has no extensions
    Given extension package was not created in "Behat/MinkExtension"
    When I release "Behat/MinkExtension" version "v2.0.0"
    Then the extension catalogue should be empty

  Scenario: Releasing repository that has documentation, but no extensions
    Given "behat/behat" version "v3.0" was documented in "Behat/docs"
    When I release "Behat/docs" version "v3.0"
    Then the extension catalogue should be empty
