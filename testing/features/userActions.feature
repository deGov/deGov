@userActions
Feature: An privileged user can login and have proper access

  @api
  Scenario: Create users
    Given users:
      | name     | mail            | status |
      | Joe User | joe@example.com | 1      |
    And I am logged in as a user with the "administrator" role
    When I visit "admin/people"
    Then I should see the link "Joe User"

  @api
  Scenario: Login as a user created during this scenario
    Given users:
      | name     | mail            | status |
      | Joe User | joe@example.com | 1      |
    When I am logged in as "Joe User"
    Then I should see "Joe User"

  @api
  Scenario: Verify Administrator access to /admin
    Given users:
      | name        | mail        | roles         |
      | user1       | user@em.ail | administrator |
    And I am logged in as "user1"
    And I am on "/admin"
    Then the response status code should be 200

  @api @cronRun
  Scenario: Run cron
    Given I am logged in as a user with the "administrator" role
    When I run cron
    And am on "admin/reports/dblog"
    Then I should see "Cron-Lauf vollständig."