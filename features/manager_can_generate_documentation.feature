Feature: Manager can generate documentation
  In order to help newcomers start using behat
  As a documentation manager
  I want documentation to be generated from the source

  Rules:
    - Documentation for Behat should be published
    - Documentation for both versions should be published

  @critical
  Scenario: Generating behat 3.0 documentation
    Given "Behat/docs" version v3.0 was documented
    When I release "Behat/docs" version v3.0
    Then the documentation for "Behat/docs" version v3.0 should have been published

  Scenario: Generating both behat 2.5 and 3.0 documentation
    Given "Behat/docs" version v2.5 was documented
    And "Behat/docs" version v3.0 was documented
    When I release "Behat/docs" version v2.5
    And I release "Behat/docs" version v3.0
    Then the documentation for "Behat/docs" version v2.5 should have been published
    And the documentation for "Behat/docs" version v3.0 should have been published
