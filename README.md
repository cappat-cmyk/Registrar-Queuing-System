# Registrar-Queuing-System

This is our capstone project. It is created with the use of web frameworks, I am mostly assigned in handling data and managing database which is MySQL.
Upon the development, we use XAMPP to hosts our trial web application. Some of the Languages and markups used are:

- HTML5
- BOOTSTRAP
- PHP
- CSS
- AJAX
- JAVASCRIPT

We also used some built-in libraries like PHP Mailer for sending email function and Node.js application for sending real-time data, run the server and say the
customer's ticket number. With this, we are able to create a project that fulfills all the requirement of the Pilot area . This project is a role-based when run, it includes: 
Client, Evaluator, and University Registrar. What users can do are listed below:

Client (Student,Employee,Others)
- Choose the role, and the queue where they are destined like regular or priority
- Choose the course they are destined to
- The system will give ticketnumber that is composed of some characters and appended number

Sample Screenshots:
![1_Client_Registration_Choose Course](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/d859e40a-dd1a-4331-a631-39f9adeb11c9)
![1_Client_Registration_Choose User Type](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/63d5ec95-f0cb-4442-b08f-a02d37a008c1)
![2_Client_Registration_Choose Course](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/3f1fdc3e-ac7c-48e0-9ead-8f236087c0d4)
![1_Client_Registration_If FacultyorEmployee](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/c6575fe0-f71a-4afa-9429-91437b064b3e)
![1_Client_Registration_If Others](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/720b8c8f-3912-4340-ab8c-82f5b831f963)
![1_Client_Registration_If Student](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/3c0a9134-dd56-4ffe-bfda-8a14738976ae)
![1_Client_Registration_If Student_Claim](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/07488f2b-1feb-4e71-9d25-f5f0a7aa3e79)
![1_Client_Registration_If Student_Request](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/8329a5d9-c58b-4f53-8993-fa1b2e6983f5)


Evaluator
- See the List of Client queue
- Could cater customer by regular or priority queue (it is based on the FCFS Algorithm)
- Call and recall the customer
- Fill up client's information
- In case that it is a enrolled student, they could easily retrieved information by inputting student id number
- They can set the customer for on-hold, incomplete or finished
- When they select finish, the system will email the school email of the student to send the verification of their transaction and the date when it could be claimed

![1_evaluator-page](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/4d61f72e-d0d1-4b29-ae79-3d68ca30b408)
![2_evaluator-onhold-transaction](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/5c8a9440-573c-4635-84a3-5efde4d21520)
![3_evaluator-page-dropdown-menu](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/17da32d5-4b9c-498c-ae2f-96049048bf5d)
![Evaluator_SampleClient](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/e089f7b7-0240-490b-9bce-31f2f19ef785)


University Registrar
- He/She can manage Users, Program/Department, Credential, Reports
![University Registrar - Choose file for import](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/b282cfe5-052b-4008-bb5d-2d7c08f93d72)
![University Registrar - Credential - 1](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/e54e91b8-af25-4f18-9085-21a06f9a90e5)
![University Registrar - Credential - Add](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/5ee54a6a-e400-4cbc-b648-a34497e5816c)
![University Registrar - Credential - Delete](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/07e9fbd3-df26-4388-95c1-1d66e14bcc5a)
![University Registrar - Credential - Edit](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/b5972425-8ea2-4e21-9137-0eb5bb2e37f5)
![University Registrar - Import and Report Generation  - Import Success](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/45aafb8b-9254-42ba-a696-649d78b082c8)
![University Registrar - Import and Report Generation - Exported data](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/64899d56-743e-46cf-9244-0f995e0d96df)
![University Registrar - Import and Report Generation - Importation process](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/dbe56d9d-c7c3-485a-b786-9d2f84d92aa3)
![University Registrar - Import and Report Generation - Overview](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/3c7f850d-e9a5-4f11-a037-39ac0e8431ac)
![University Registrar - ManageUsers - Add](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/4300b82d-fc12-4bca-aebd-358694884a30)
![University Registrar - ManageUsers - Delete](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/a4c16025-87d1-4218-898a-0a1082baeb77)
![University Registrar - ManageUsers - Edit](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/cff45188-2c65-4b0f-921f-eed3e082d39c)
![University Registrar - ManageUsers - Overview](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/062ff8e4-4aa7-4a8c-8177-2d9113efcb96)
![University Registrar - Search function](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/bf5d9f2d-bf1d-4a37-b946-7b948ba3561e)

Login Screenshots
![forgot-password](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/b6008a0c-a2ad-4378-a2e8-1914254293d5)
![login-interface](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/d6f8a939-cddb-4ca3-8c24-79f8d28bd897)
![reset-password](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/0835fd78-f410-49b6-9949-22a5451fa90c)

TV Display Screenshot
![queue-tv-display](https://github.com/cappat-cmyk/Registrar-Queuing-System/assets/76167342/15851649-4a4c-49ca-a29c-788cb179520f)



