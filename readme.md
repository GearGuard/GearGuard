# Project Setup Instructions

Follow the steps below to set up and run the project on your local machine.

## Prerequisites

1. **Clone the Repository or Download the Archive**  
   - Clone the repository using Git:  
  
     ```bash
     git clone https://github.com/GearGuard/GearGuard.git
     ```

   - Alternatively, download the project as a ZIP archive and extract it.

2. **Install Composer**  
   Ensure that [Composer](https://getcomposer.org/Composer-Setup.exe) is installed on your machine.  
   To install Composer, download it from [here](https://getcomposer.org/Composer-Setup.exe) and follow the instructions.

3. **Database**  
   Create a database on myphpadmin called ``gearguard``.
   

## Installation Steps

1. **Navigate to the Project Directory**  
   Open a terminal in the project root directory.

2. **Install Dependencies**  
   Run the following command to install all required dependencies:  

   ```bash
   composer install
   ```

3. Create a ``.env`` file and follow the ``.evn.example`` file format the database.
4. Run bellow command on terminal.
   ```
   php migrations.php
   ```
5. Go to the public folder 
   ``` 
   cd public
   ```
6. Start php server by running command 
   ```
   php -S 127.0.0.1:8080
   ```
   or
   ``` 
   php -S localhost:8080
   ```
7. Open browser and run ``http://localhost:8080``
