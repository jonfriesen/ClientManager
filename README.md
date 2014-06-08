Client Manager
==============

This client manager was built in my earlier years in college as for a small IT company that focused on consumer computer care and sales. Their painpoint was managing their clients, technicians, and service calls between eachother as most of the technicians worked remotely.

This web application handled all these three points solving their pain point. Since the original development I've rewritten most of the PHP, converting database access from the `mysqli` library to the newer, more reboust `PDO` library.

When exploring the code you will notice some *scar tissue* where I've implemented additional functionality, bug fixes, and refactors (eg. the `PDO` implementation in the `Data\Connection.php` page).

##Installation
1. Run the SQL Script `Install\installscript.sql` on a MySQL database
2. Set MySQL credentials in `Data\config.ini`
3. SQL script comes with some sample data, admin login
	username: admin
	password: Hello

##Cautionary Points
- Passwords are currently stored in plain text. They should be stored in a salted hash format
- Database access is new and needs further vetting and experimentation
- I know the UI isn't the prettiest. The client needed a fast, functional product and thus prettiness was sacrificed