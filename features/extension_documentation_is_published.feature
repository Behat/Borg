Feature: Extension documentation is published
  In order to help newcomers start extending behat quicker
  As a documentation contributor
  I want extensions documentation to be published after contributors release a new versions of them

  Rules:
  - Extensions documentation is published
  - `master` and `develop` branches documentation should also be published (if documented)

  Scenario: Publishing extension release documentation
    Given "behat/symfony2-extension" version "v2.0.0" was documented in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "v2.0.0"
    Then "behat/symfony2-extension" version "v2.0" documentation should have been published

  @critical
  Scenario: Publishing extension master-branch documentation
    Given "behat/symfony2-extension" version "master" was documented in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "master"
    Then "behat/symfony2-extension" version "master" documentation should have been published

  Scenario: Publishing extension develop-branch documentation
    Given "behat/symfony2-extension" version "develop" was documented in "Behat/Symfony2Extension"
    When I release "Behat/Symfony2Extension" version "develop"
    Then "behat/symfony2-extension" version "develop" documentation should have been published
