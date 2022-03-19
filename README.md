# L3. Requirements and Code Quality
**Some things are not yet implemented and this project has buggs, which are noted in the source code.**

## Requirements
- A heroku account at [Heroku](https://heroku.com).
- Following Add-ons on heroku:
    - Adminium
    - JawsDB MySQL


- XAMPP installed for local testing and developement.

### 
# ToPictureIt

[ToPictureIt App](https://labb2.herokuapp.com/)


Test credentials:


Username: Admin


Password: Password


Sebastian Jonsson (sj223gb)

[Project Wiki](https://gitlab.lnu.se/1dv610/student/sj223gb/lab2/-/wikis/Home)

## Getting Started in Developement Mode

- Download the Repository.
- Install XAMPP & boot/start it.
    - Enter [phpmyadmin](http://localhost/phpmyadmin/).
    - Create a database named anything you like or default it to 'users'.
    - Enter the database and create two new tables:
        - 'pictureits'
            - Make sure to have the following rows:
                - 'id'(To be Auto-Incremented, type: int(11) Primary key.)
                - 'pictureurl'(varchar(255))
                - 'description'(varchar(255))
                - 'tag'(varchar(255))
        - 'userlist'
            - Make sure to have the following rows:
                - 'username'(text)
                - 'password'(text)
    
- Enter the Repository folder.
- In AuthModule and ToPictureIt folders, go into the Model/DAL/Database.php file.
    - Here you set your localhost settings for the developement environment (To be updated).
        - Default settings for this app. (May differ from your installation, such as no password required.)
        ```
        private static $dblocalhost = 'localhost';
        private static $dbusername = 'root';
        private static $dbpassword = 'root';
        private static $db = '<Your_Database_Name_String>'; // Default value to 'users'.
        ```
            - (To be updated for more automated settings, see AuthModule\model\DAL\ExperimentalDB.php(Not yet implemented.))

- Ready to run locally.


## Getting Started in production on Heroku

- Create previous tables mentioned in Getting started in Developement Mode.
- Create your heroku app.
- Add the Add-ons mentioned in Requirements to your heroku app. (Credit card required for identification, no payment needed)
- Attach them to your heroku app. [JawsDB Guide](https://devcenter.heroku.com/articles/jawsdb). Preferable to choose heroku's connection way.
- Enter Adminium in your heroku app resources and repeat the Create Database steps in Getting Started in Developement Mode above.
    - Types of rows may differ but should be 'int(11)'(Auto increment), the remaining fields to be of type 'varchar(255)'
- Confirm your heroku app Settings in Config Vars, to contain the ADMINIUM_URL(with value) and JAWSDB_URL(with your 'connection string' provided by JawsDB under resrouces.).



## Use Cases

Follow this Link to the [Use Cases](https://gitlab.lnu.se/1dv610/student/sj223gb/lab2/-/wikis/Use-Cases)


## TODO - Implementation and Fixes

- As mentioned briefly, a database that handles the Local settings and the Production settings for easier configuration.
- Further database updates in terms of functionality such as queries.

- Edit and Search by Tag functionality to be added to the ToPictureIt module.
- Fix input tag issue of ToPictureIt module.
- Allow access to view ToPictureIts as logged out but not alter in any way.
- Implement the option to upload pictures along with current third-party URL's.

- Cookies are yet to be implemented and it's functionality.
- Session require further refinement in terms of security.

- Exception management that happens in controllers can be further refined.
- Further refine MainControllers in an understandable manner. (ChangeState, Generate Output functions)

- Further refine code quality.

