@addingMedia
Feature: A privileged user can add media

  @api
  Scenario: User can add media (document)
    Given users:
    | name        | mail        | roles         |
    | editingUser | user@em.ail | administrator |
      And I am logged in as "editingUser"
      And I am on "/media/add/document"
      Then for "Media name" I enter "testMedia"
      When I attach the file "documents/dummy_pdf.pdf" to "Dokument"
      And I should see the button "Speichern und veröffentlichen"
      Then I click the "input.form-submit[value='Speichern und veröffentlichen']" element
      And I should see "testMedia"

  @api
  Scenario: User can add media (image)
    Given users:
      | name        | mail        | roles         |
      | editingUser | user@em.ail | administrator |
    And I am logged in as "editingUser"
    And I am on "/media/add/image"
    Then for "Media name" I enter "testMedia"
    When I attach the file "images/placeholder.png" to "Image"
    And for "Bildunterschrift" I enter "placeholder"
    And I should see the button "Speichern und veröffentlichen"
    Then I click the "input.form-submit[value='Speichern und veröffentlichen']" element
    And I should see "testMedia"

  @api
  Scenario: User can add media (Kontakt hinzufügen)
    Given users:
      | name        | mail        | roles         |
      | editingUser | user@em.ail | administrator |
    And I am logged in as "editingUser"
    And I am on "/media/add/contact"
    Then for "Media name" I enter "testMedia"
    And for "Name" I enter "Jhon"
    And for "Telefonnummer" I enter "04793680953"
    And for "Fax" I enter "04793669955"
    And for "E-Mail" I enter "Jhon@example.com"
    And for "Position" I enter "Manager"
    And I should see the button "Speichern und veröffentlichen"
    Then I click the "input.form-submit[value='Speichern und veröffentlichen']" element
    And I should see "testMedia"