# Accounting-Workflow
A browser based monthly workflow scheduler mainly for accounting businesses.

If you want to see a working demo version, check out the link to my website section

<http://www.codexl.fi/data/awdemo/workflow_demo.php>

Please notice that in the demo version, all the server side actions have been disabled for obvious reasons.

This is a fully functional web page, that requires modification for a specific SQL Database.

Current features:
* Monthly schedule tracking for clients
* A full client registry with company information and contacts
* Super easy one-click functianality to add current date to desired table cell
* Ajax based update system for table cells, prevents page reload but still executes php
* Color marked cell for upcoming important dates like: VAT-dates, salaries, financial statements etc.
* JQueryUI based dialog -comment box for every client per month
* Create next workflow-month based on desired clients from registry
* Ease GUI section for adding single clients to workflow control
* One-click function to create a whole month tracking for every client
* Very much a work in progress, still contains inline php, multiple declarations possibly etc.

The finnish business law dictates many different monthly dates and events when companies must report certain figures
eg. monthly VAT or amount of salaries payed.

This workflow scheduler is designed specificly for accounting businesses that have many small or medium sized
clients. Overseeing many clients reporting dates cant be cumbersome, and this browser based PHP and MySQL application
makes that a lot easier.

The application requires some sort of a server that can run PHP and have access to a modifiable MySQL database.

It does not yet self-install the required database, and it requires a very specific database to operate, mainly certain types of field names and values it can hold. As of now there has been no reason to add a self-installation.

This version of the application has been stripped of everything that relates to privacy of the clients if maintains,
the database, passwords and such. As of such it does not include a database at all.

A demo version of this application will be added soon, with the information about the required database structure.
