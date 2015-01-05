Feature: Documentation is published on repository release
  In order to help newcomers start extending behat quicker
  As a documentation contributor
  I want extensions documentation to be published after contributors release a new versions of them

  Rules:
  - Extensions documentation is published

  @critical
  Scenario: Publishing extension release documentation
    Given "behat/symfony2-extension" version "v2.0.0" was documented in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    Then "behat/symfony2-extension" version "v2.0" documentation should have been published
