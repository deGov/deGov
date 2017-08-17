@ContentTypesPresent
Feature: Test presence of content-types
  A user with sufficiant permission can can confirm that all the relevant preconfigurations
  have taken place.

  @api
  Scenario: Preconfigured content-types are present
    Given users:
      | name  | mail        | roles         |
      | user1 | user@em.ail | administrator |
    And I am logged in as "user1"
    And  I am on "/admin/structure/types"
    Then I should see the link "Inhaltstyp hinzufügen"
    And I should see "Blogartikel" in the "content_region"
    And I should see "Inhaltsseite" in the "content_region"
    And I should see "Pressemitteilung" in the "content_region"
    And I should see "Veranstaltung" in the "content_region"

  @api
  Scenario: Preconfigured fields on normal-pages are present
    Given users:
      | name       | mail        | roles         |
      | fieldAdmin | user@em.ail | administrator |
    And I am logged in as "fieldAdmin"
    And I am on "/admin/structure/types/manage/normal_page/fields"
    Then I should see the link "Feld hinzufügen"
    And I should see the link "Add Update field"
    And I should see "Inhaltsbereich" in the "content_region"
    And I should see "Kopfbereich" in the "content_region"
    And I should see "Schlagworte" in the "content_region"
    And I should see "Seitenleiste rechts" in the "content_region"
    And I should see "Social Media Buttons anzeigen" in the "content_region"
    And I should see "Vorschau Bild" in the "content_region"
    And I should see "Vorschau Text" in the "content_region"
    And I should see "Vorschau Titel" in the "content_region"

  @api
  Scenario: All the relevant pragraphs are present
    Given users:
      | name           | mail        | roles         |
      | paragraphAdmin | user@em.ail | administrator |
    And I am logged in as "paragraphAdmin"
    And I am on "/admin/structure/paragraphs_type"
    Then I should see the link "Absatzart hinzufügen"
    And I should see "Ansichtsreferenz" in the "content_region"
    And I should see "Downloads" in the "content_region"
    And I should see "FAQ" in the "content_region"
    And I should see "FAQ / Akkordion Liste" in the "content_region"
    And I should see "Iframe" in the "content_region"
    And I should see "Image Header" in the "content_region"
    And I should see "Inhaltsreferenz" in the "content_region"
    And I should see "Link-Liste" in the "content_region"
    And I should see "Map" in the "content_region"
    And I should see "Medienreferenz" in the "content_region"
    And I should see "Slide" in the "content_region"
    And I should see "Slideshow" in the "content_region"
    And I should see "Text" in the "content_region"
    And I should see "Untertitel" in the "content_region"
    And I should see "Webformular" in the "content_region"

  @api
  Scenario: All the relevant pragraphs are present
    Given users:
      | name          | mail        | roles         |
      | mediaRefAdmin | user@em.ail | administrator |
    And I am logged in as "mediaRefAdmin"
    And I am on "/admin/structure/paragraphs_type/media_reference/fields"
    Then I should see the link "Feld hinzufügen"
    And I should see the link "Add Update field"
    And I should see "Bildunterschrift" in the "content_region"
    And I should see "Media" in the "content_region"
    And I should see "Titel" in the "content_region"
    And I should see "Untertitel" in the "content_region"

  @api
  Scenario: All the relevant pragraphs are present
    Given users:
      | name                  | mail        | roles         |
      | mediaRefSettingsAdmin | user@em.ail | administrator |
    And I am logged in as "mediaRefSettingsAdmin"
    And I am on "/admin/structure/paragraphs_type/media_reference/fields/paragraph.media_reference.field_media_reference_media"
    Then the "Dokument" checkbox should be checked
    And the "Image" checkbox should be checked
    And the "Instagram" checkbox should be checked
    And the "Kontakt" checkbox should be checked
    And the "Tweet" checkbox should be checked
    And the "Video" checkbox should be checked
    And the "Adresse" checkbox should not be checked
    And the "Bildergalerie" checkbox should not be checked
    And the "Citation" checkbox should not be checked
    And the "Person" checkbox should not be checked
    And the "Video Upload" checkbox should not be checked

  @api
  Scenario: The Cookie-Compliane is configured propperly
    Given users:
      | name                  | mail        | roles         |
      | cookieComplianceAdmin | user@em.ail | administrator |
    And I am logged in as "cookieComplianceAdmin"
    And I am on "/admin/config/system/eu-cookie-compliance"
    Then the "Enable popup" checkbox should be checked
    And the "Consent by clicking" checkbox should be checked
    And the "Open privacy policy link in a new window" checkbox should be checked
    And the "Place the pop-up at the top of the website" checkbox should not be checked
    And the "Enable thank you message" checkbox should not be checked
    And the "Clicking hides thank you message" checkbox should not be checked
    And the "Agree button message" field should contain "Ich stimme zu"
    And the "Disagree button message" field should contain "Mehr Informationen"
    And the "Privacy policy link" field should contain "http://www.mik.nrw.de/service/impressum.html"

  @api
  Scenario: The searchindex has the propper configuration
    Given users:
      | name             | mail        | roles         |
      | searchIndexAdmin | user@em.ail | administrator |
    And I am logged in as "searchIndexAdmin"
    And I am on "/admin/config/search/search-api/index/content/edit"
    Then the "Index-Name" field should contain "Inhalt"
    And the "Inhalt" checkbox should be checked
    And the "Absatz" checkbox should not be checked
    And the "Benutzerdefinierter Block" checkbox should not be checked
    And the "Benutzerdefinierter Menülink" checkbox should not be checked
    And the "Datei" checkbox should not be checked
    And the "Medien" checkbox should not be checked
    And the "Scheduled update" checkbox should not be checked
    And the "Search task" checkbox should not be checked
    And the "Taxonomy term" checkbox should not be checked
    And the "User" checkbox should not be checked
    And the "Verknüpfungslink" checkbox should not be checked
    And the "Webformulareingabe" checkbox should not be checked
    And the "Zuschneide" checkbox should not be checked
    And the "Aktiviert" checkbox should be checked
    And the "Index items immediately" checkbox should be checked
    And the "Nur Lesen" checkbox should not be checked
    And the "Database" radiobutton should not be selected
    And the "-No server-" radiobutton should not be selected
