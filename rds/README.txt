
Basic RDS Creation/Usage:
1.  Create an RDS instance that allows public access from your IP.
2.  Assuming a username of "admin", test connection to the RDS instance with the command:
	mysql -u admin -p -h <hostname>
	
	If test successful, you should be able to connect and then run a command like "show databases;"
	If test not successful, verify that the instance is running and that the Security Groups allows tcp/3306 from public.
	
3.  Use the testschema.sql file to create a database, a table, and insert some rows:
	mysql -u admin -p -h <hostname> < testschema.sql

4.  Log back in (see command from #2) and run:
	show databases
	
	Expected Result:  Should see a database named "auth" in the list.
	
	Run:
	select * from auth.users;
	
	Expected Result:  Should see a list of three users.

Elastic Beanstalk:
- Assumes that you have completed the steps in "Basic RDS Creation/Usage".  If not, go complete those!

1.  Find the file creds.inc within the web folder.
2.  Update creds.inc to include the username, password, and hostname.
3.  Create the Elastic Beanstalk application.

