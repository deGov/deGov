@addingTerm
Feature: A privileged user can add terms in selected taxonomies

  @api
  Scenario: User can add terms in taxonomy
    Given I am logged in as a user with the "administrator" role
    And I am on "/admin/structure/taxonomy/manage/copyright/overview"
    When I click "Begriff hinzufügen"
    And for "Name" I enter "TestTerm"
    And I press "Speichern"
    Then I should see "Der neue Begriff TestTerm wurde erstellt."