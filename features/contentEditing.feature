@ContentEditing
Feature: An priviledged user can create a normal page
  @api
  @development
  Scenario: User can create a normal page
    Given users:
      | name        | mail        | roles         |
      | editingUser | user@em.ail | administrator |
    And I am logged in as "editingUser"
    And I am on "/node/add/normal_page"
    Then for "Titel" I enter "testTitle"
    And for "Vorschau Titel" I enter "previewTitle"
    And for "Vorschau Text" I enter "previewContent"
    And I should see the button "Downloads hinzufügen"
    And I should see the button "FAQ hinzufügen"
    And I should see the button "FAQ / Akkordion Liste hinzufügen"
    And I should see the button "Iframe hinzufügen"
    And I should see the button "Image Header hinzufügen"
    And I should see the button "Link-Liste hinzufügen"
    And I should see the button "Map  hinzufügen"
    And I should see the button "Inhaltsreferenz hinzufügen"
    And I should see the button "Slide hinzufügen"
    And I should see the button "Slideshow hinzufügen"
    And I should see the button "Text hinzufügen"
    And I should see the button "Untertitel hinzufügen"
    And I should see the button "Ansichtsreferenz hinzufügen"
    And I should see the button "Webformular hinzufügen"
    Then I click the "input.form-submit[value='Ansichtsreferenz hinzufügen']" element
    And I should see "Views row view mode"
    And I select "Suche" from "Ansicht"
    Then I click the "input.form-submit[value='Speichern als unveröffentlicht']" element
    And I should see "testTitle"

