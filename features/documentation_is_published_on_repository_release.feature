Feature: Documentation is published on repository release
  In order to help newcomers start using behat
  As a documentation contributor
  I want documentation to be published after we release new version of it

  Rules:
  - Documentation for Behat should be published
  - Documentation for both versions should be published
  - Extensions documentation is also published

  @critical
  Scenario: Publishing behat 3.0 documentation
    Given "behat/behat" version "v3.0" was documented in "Behat/docs" repository
    When I release "Behat/docs" version "v3.0"
    Then "behat/behat" version "v3.0" documentation should have been published

  Scenario: Publishing both behat 2.5 and 3.0 documentation
    Given "behat/behat" version "v2.5" was documented in "Behat/docs" repository
    And "behat/behat" version "v3.0" was documented in "Behat/docs" repository
    When I release "Behat/docs" version "v2.5"
    And I release "Behat/docs" version "v3.0"
    Then "behat/behat" version "v2.5" documentation should have been published
    And "behat/behat" version "v3.0" documentation should have been published

  Scenario: Publishing extension documentation
    Given "behat/symfony2-extension" version "v2.0.0" was documented in "Behat/Symfony2Extension" repository
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    Then "behat/symfony2-extension" version "v2.0" documentation should have been published

  @critical
  Scenario: Not publishing documentation if release was not documented
    Given "everzet/persisted-objects" version "v1.0.0" was not documented
    When I release "everzet/persisted-objects" version "v1.0.0"
    Then "everzet/persisted-objects" version "v1.0" documentation should not be published
