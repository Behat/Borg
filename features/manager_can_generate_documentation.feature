Feature: Manager can generate documentation
  In order to help newcomers start using behat
  As a documentation manager
  I want documentation to be generated from the source

  Rules:
    - Documentation for both 2.5 and 3.0 should be generated
    - If documentation gets updated, we should regenerate it
    - If documentation wasn't updated, we should keep the old version

  @critical
  Scenario: Generating behat 3.0 documentation
    Given "Behat/docs" version v3.0 was documented
    When I build the documentation
    Then the documentation for "Behat/docs" version v3.0 should have been published

  Scenario: Generating both behat 2.5 and 3.0 documentation
    Given "Behat/docs" version v2.5 was documented
    And "Behat/docs" version v3.0 was documented
    When I build the documentation
    Then the documentation for "Behat/docs" version v2.5 should have been published
    And the documentation for "Behat/docs" version v3.0 should have been published

  Scenario: Regenerating updated documentation
    Given "Behat/docs" version v2.5 documentation was built
    And "Behat/docs" version v3.0 documentation was built
    When "Behat/docs" version v2.5 documentation is updated
    And I build the documentation again
    Then the documentation for "Behat/docs" version v2.5 should have been republished
    But the documentation for "Behat/docs" version v3.0 should not have been republished
