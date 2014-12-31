Feature: Documentation meta is generated after publishing
  In order to help users find relevant information quicker
  As a documentation contributor
  I want documentation meta to be available after publishing

  Meta:
  - Documentation package name and update time
  - Links to other published versions of documentation
  - Link to the current documentation page editor

  Scenario: Getting documentation package name and update time
    Given "Behat/docs" version "v3.0" was documented on "31.12.2014"
    When I release "Behat/docs" version "v3.0"
    Then package name of "index.html" page for "Behat/docs" version "v3.0" should be "Behat/docs"
    And documentation time of "index.html" page for "Behat/docs" version "v3.0" should be "31.12.2014"
