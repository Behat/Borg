Feature: Documentation is published on repository release
  In order to help newcomers start using behat quicker
  As a documentation contributor
  I want behat documentation to be published after we release a new version of it

  Rules:
  - Documentation for Behat should be published
  - Documentation for both versions should be published

  @critical
  Scenario: Publishing behat 3.0 documentation
    Given "behat/behat" version "v3.0" was documented in "Behat/docs"
    When I release "Behat/docs" version "v3.0"
    Then "behat/behat" version "v3.0.x" documentation should have been published

  Scenario: Publishing both behat 2.5 and 3.0 documentation
    Given "behat/behat" version "v2.5" was documented in "Behat/docs"
    And "behat/behat" version "v3.0" was documented in "Behat/docs"
    When I release "Behat/docs" version "v2.5"
    And I release "Behat/docs" version "v3.0"
    Then "behat/behat" version "v2.5.x" documentation should have been published
    And "behat/behat" version "v3.0.x" documentation should have been published

  @critical
  Scenario: Not publishing documentation if release was not documented
    Given "everzet/persisted-objects" version "v1.0.0" was not documented
    When I release "everzet/persisted-objects" version "v1.0.0"
    Then "everzet/persisted-objects" version "v1.0" documentation should not be published
