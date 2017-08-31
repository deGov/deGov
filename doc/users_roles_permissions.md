# Users / Roles / Permissions

Setup instructions for Workbench Access

1. Create a vocabulary and add terms that represents the editorial sections of the site (including hierarchies)
2. Add a taxonomy term reference field to the node types that should be controlled by the module (select the vocabulary create in the step above)
3. Got to the workbench access config form /admin/config/workflow/workbench_access, select the taxonomy access scheme and the aforementioned vocabulary
4. Check the nodes types from step 2 and select the taxonomy term reference field in the dropdown
5. Go to the sections form and add individual users or roles to the sections as required /admin/config/workflow/workbench_access/sections