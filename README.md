# VotingSystem
A voting system with nominations.
Originally made for KLBS

Please note that this program makes use of the PHP each() function that was deprecated in PHP 7.2

Released under GPLv3 By D.Trickey


Voting System Usage Instructions

1. Run the php artisan vote:setup command with your user list.
2. When the time for nominations is up:
1. php artisan down
2. php artisan vote:nominate to calculate the nominees
3. Change the mode in the env file to 2 (vote mode)
4. php artisan up