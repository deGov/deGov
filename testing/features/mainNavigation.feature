@mainNavigation
Feature: An priviledged user can create a menu link
  @api
  Scenario: User can create a menu link
    Given users:
      | name        | mail       | roles         |
      | moderator1 | user@em.ail | administrator |
    And I am logged in as "moderator1"
    And I am on "/admin/structure/menu/manage/main"
    When I click on "Link hinzufügen" with selector "ul.action-links li a"
    Then I should be on "/admin/structure/menu/manage/main/add"
    And for "Linktitel des Menüpunkts" I enter "MainLink"
    And for "Link" I enter "#"
    And for "Beschreibung" I enter "A test menu"
    Then I click the "input.form-submit[value='Speichern']" element
    And I should see "MainLink"