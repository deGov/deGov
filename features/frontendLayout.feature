@AnonymousUser
Feature: Startpage accessible
  As an anonymous user I should see the startpage

  Scenario: I am an anonymous user
    Given I am an anonymous user
    Given I am on "/"
    Then I should see the link "Anmelden / Registrieren"
    When I click "Anmelden / Registrieren"
    Then I should be on "/user/login"

  @mink:selenium2    # changes browser-engine, we want to use selenium instead of gaute
  @browser_name:chrome  # leaving this empty will cause firefox nightly to be loaded
  Scenario: Testing Resolution
    Given I am on "/"
    And I resize the window to "710" x "1024"
    Then I should see "TECHNISCHES MENU"