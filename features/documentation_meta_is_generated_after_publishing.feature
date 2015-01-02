@critical
Feature: Documentation meta is generated after publishing
  In order to help users find relevant information quicker
  As a documentation contributor
  I want documentation meta to be available after publishing

  Meta:
  - Documentation package name and update time
  - Links to other published versions of documentation
  - Link to the current documentation page editor

  Scenario: Getting documentation package name and update time
    Given "Behat/Symfony2Extension" version "v2.0.0" was documented on "04.09.2014 22:10:45"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    Then package name of "index.html" page for "Behat/Symfony2Extension" version "v2.0" should be "behat/symfony2-extension"
    And documentation time of "index.html" page for "Behat/Symfony2Extension" version "v2.0" should be "04.09.2014 22:10:45"

  Scenario: Getting alternative documentation versions
    Given "Behat/docs" version "v2.5" was documented
    And "Behat/docs" version "v3.0" was documented
    When I release "Behat/docs" version "v2.5"
    And I release "Behat/docs" version "v3.0"
    Then documentation for "v2.5" should be in the list of available documentation for "Behat/docs"
    And documentation for "v3.0" should be in the list of available documentation for "Behat/docs"
