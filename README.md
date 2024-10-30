# Civil-Registry-System
Web Based Civil Registry System (Civil Registry is the online system or agency to help the Indian citizens to apply for their government records like passport and register certificates for birth, death etc.)


# steps to run this project on your system

1.download and setup wampserver (refer youtube for how to )




2.start the wampserver and make sure all the services are running (refer youtube)




3.open phpmyadmin through wampserver and paste the following code to design a database in sql section in navigation panel : 



DROP DATABASE IF EXISTS civil_registry;
CREATE DATABASE civil_registry;
USE civil_registry;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    password VARCHAR(100),
    role ENUM('admin', 'applicant')
);
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type ENUM('passport', 'birth_certificate', 'death_certificate'),
    status ENUM('verifying documents', 'checking background', 'in final review', 'approved') DEFAULT 'verifying documents',
    data JSON,
    FOREIGN KEY (user_id) REFERENCES users(id)
);





4.go to folder named www on your system inside wamp64 folder usually located at C:\wamp64\www\ and create folder named "civil_registry" inside this create folder named "uploads" and now open civil_registry folder in vs code now copy the following command and paste in terminal of vs code: 


git clone https://github.com/PranavGove/Civil-Registry-System.git





5.open your browser and paste this 

http://localhost:80/civil_registry 





THAT'S IT !

# Screenshots 
![image](https://github.com/user-attachments/assets/5e586405-d0ee-4a80-b0cc-9068a699a2ce)
![image](https://github.com/user-attachments/assets/dec43d75-14bf-4bae-a692-b3d4167cfdba)
![image](https://github.com/user-attachments/assets/a1ac5889-97fa-47c5-a48e-c3358b35b3e3)
![image](https://github.com/user-attachments/assets/56501a1e-5d6a-4ccb-8979-dfa5e4be2db2)
![image](https://github.com/user-attachments/assets/1dd79864-e4d6-4752-ad06-e82d532cc8c1)
![image](https://github.com/user-attachments/assets/8b14b9ce-91f3-43df-a3c1-91866614f054)



