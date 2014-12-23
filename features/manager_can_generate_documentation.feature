Feature: Manager can generate documentation
  In order to help newcomers start using behat
  As a documentation manager
  I want documentation to be generated from the source

  Rules:
    - Documentation for both 2.5 and 3.0 should be generated
    - If documentation gets updated, we should regenerate it
    - If documentation wasn't updated, we should keep the old version

  Scenario: Generating behat 3.0 documentation
    Given "behat/docs" version 3.0 was documented
    When I build the documentation
    Then the documentation for "behat/docs" version 3.0 should have been built

  Scenario: Generating both behat 2.5 and 3.0 documentation
    Given "behat/docs" version 2.5 was documented
    And "behat/docs" version 3.0 was documented
    When I build the documentation
    Then the documentation for "behat/docs" version 2.5 should have been built
    And the documentation for "behat/docs" version 3.0 should have been built

  Scenario: Regenerating updated documentation
    Given "behat/docs" version 2.5 documentation was built
    And "behat/docs" version 3.0 documentation was built
    When "behat/docs" version 2.5 documentation is updated
    And I build the documentation again
    Then the documentation for "behat/docs" version 2.5 should have been rebuilt
    But the documentation for "behat/docs" version 3.0 should not have been rebuilt
