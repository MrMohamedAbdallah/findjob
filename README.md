# **Find job**
Findjob is a website for finding & applying for jobs and sharing CVs online.

## **Setup**
1. Clone the project
2. Create database and config `.env` file
3. Run this command for storage config in laravel
    ```bash
    php artisan storage:link
    ```
4. Run this command for database migration & seeders **_It's important for roles_**
    ```bash
    php artisan migrate
    php artisan db:seed
    ```
5. After seeding there will be one root user
    ```
    Email: root@example.com
    Password: password
    ```

### **Roles**
| Name  | Privileges |
|-------|--------|
|User   |<ul><li>Create a job</li><li>Apply for a job</li></ul>|
|Admin  |<ul><li>Create a job</li><li>Apply for a job</li><li>Mange users jobs</li><li>Deactivate users</li></ul>|
|Root  |<ul><li>Create a job</li><li>Apply for a job</li><li>Manage all jobs</li><li>Can add or delete any role for any user **includeing root users**</li></ul>|

_i've built this website to practice building websites using Laravel_

**What I learned from it 😊**
* Dealing with file uploading & deleting with laravel
* Building multi auth system using Laravel
* Building API using laravel
* Building tag system
* Creating masonry layout with `macy.js`

### **Tools, Framworks And Libraries**
--------------------------------------
1. Design
    * Adobe XD
    * Illustrator (for the logo)
2. Backend
    * Laravel
3. Frontend
    * Bootstrap
    * Fontawesome

## **Screenshots** 
------------------------
_all text are lorem ipsum_
#### **Home Page**
![Home Page](screenshots/home.png)

#### **Profile Page**
![Profile Page](screenshots/profile.png)

#### **Search Page For Jobs**
![Search for jobs](screenshots/search_job.png)

#### **Search Page For Employees**
![Search for employees](screenshots/search_employee.png)

#### **Logo**
![Findjob Logo](screenshots/logo.png)


See the design on 
[Behance](https://www.behance.net/gallery/92290643/Findjob-website)

My
[Twitter](https://twitter.com/MrMohamed98) | 
[Linkedin](https://www.linkedin.com/in/mohamed-abdallah-b731b61a2/)
