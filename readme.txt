Next Assignment - Application for Sales Team
Hi All, 

Application for Sales Team: -
same Login Page - 3 actors

1. Admin   - who can see everything . He will create BDM and few BDE's under him.
2. BDM     -  Business development Manager. He can see the records added by his BDE's
3  BDE      -  Business Development Executive.  he will add the potential customer details through a form

logout . general profile ( address, email, phone no., branch) update/edit functions once login


A set of BDE's  work under BDM. BDE's collect the client information like client name, website, company, phone no1, phone no2, email id1, email id2, email id3,  address, city, state, country, category, designation,linked in id, facebook id, twitter id
and enter into the system. you need to provide a form to BDE's once login to submit the clients details. you should show the list of clients they added with edit option.

BDM's can login and see what are all the clients added by his team. He will list of clients with a links called "Status" "Send Proposal", once clicked it will open a proposal text area with simple editor and an option to attach 3 files. He can write the proposal and click on the  send button. Mail should goto client and status of that client changes to "Mail Sent"

Admin will see the reports like how many clients added by BDE's and how many proposals sent by BDM's. Admin will create/edit/delete  BDM's and BDE's

Admin Login
--------------
Home
BDM List
BDE List
Client List - See all the client records added  and the status 
Add a client
Add a BDM
Add a BDE
Assign BDE's to BDM
Logout


BDM  login
------------
Home
Profile
BDE List
Client List - See all the client records added  and along with a link "Send proposal"
Add a client
Logout


BDE  login
------------
Home
Profile
Client List - See all the client records added  and along with a link "Status"
Add a client
Logout

In BDE's Login You should not allow to add a duplicate client.  company website should be unique. No two entries with the same website.  you need to use ajax to check after entering the company website.



Regards
Chandu.
