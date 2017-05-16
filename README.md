# Voting System
An online e-voting system with nominations.

I will think of a catchier name one day.

Please note that this program makes use of the PHP each() function that was deprecated in PHP 7.2

Released under GPLv3 By D.Trickey


##Voting System Workflow Instructions

* Install Laravel 5.4 System Requirements
* Fill out .env file. Important fields are:
    * APP_NAME - The title of the application. Displayed in emails and the navbar.
    * APP_REASON - The name of the competition e.g AGM Election
    * APP_MODE - The mode that the app is in. Takes several values, see further instructions. Set to 1 (Nomination Mode) initially.
    * APP_NOMINEE_COUNT - The number of nominees that make it to the next round.
    * APP_URL - The base URL of the website. Used in emails.
    * APP_NOMINATE_DEADLINE - Nomination deadline time in Unix time.
    * APP_VOTE_DEADLINE - Nomination deadline time in Unix time.
    * Also Database and Email Details
* Place a users.csv file in the storage directory with the following format: *Name,Email Address*
* Run the setup command: *php artisan vote:setup* and follow the instructions.
* The system is now live and users can nominate.
* The system will cease access once the deadline has passed.
* When nominations are over, run *php artisan vote:nominate* This will count the nominations and select the most popular people to be put forward.
* You may wish to make note of the output from this command.
* Change APP_MODE to 2 and run *php artisan up* to bring the system live again.
* Run *php artisan vote:notify:nominated* to inform users that they have been nominated.
* Run *php artisan vote:notify:open* to inform users that they can now vote.
* When the deadline has passed, the system will be unavailable again.
* When voting is finished, change APP_MODE to 3.
* Run *php artisan vote:count*
* The winner for each category is displayed and the system now displays that voting is finished.
     
You can also run *php artisan vote:export* to get both raw and summary data of all the nominations and votes that have been cast.
The export command will reveal whom voted for whom and store the export files in *~/storage/export*.