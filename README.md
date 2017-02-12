# Ashley Moodison (AM) 💋 - Capture the Flag (CTF)
Did you read those recent presidential leaks? Did you see the one about the Ashley Moodison website? Crazy, right! Reckon any of it's true? I know, I'm sceptical too. Only one way to find out really, let's hack the site and dump the database! 😀 😇  

## The Game
Some things to note before you get underway:
* Port scanning the machine won't lead to anything interesting
* Account passwords are hashed and salted in the database; however, assume they are plain-text because they will be breached
* While authenticated to AM you can get `CTF Hints` through your profile. This is for self-assessment only and not recorded on a tally/scoreboard. There is approximately two hints per flag and the hints progress sequentially

## Flags
This is what you're looking for:

1. FLAG: HonorablePreviousLiquidHorn
2. FLAG: ParallelSkyIdentify
3. FLAG: MountainRespectMadly
4. FLAG: ParallelSkyIdentify
5. FLAG: HOLYSMOKESYOUDIDIT!

## Deployment Notes
Here are some things to note if you're planning on deploying this game on your own hardware. This is a lousy installation guide and not an exhaustive list:

1. Setup a standard LAMP stack on `Ubuntu 14.04 LTS` - `apt-get install lamp-server^`

  * **Why 14.04?** The game needs to run on a version of `MySQL prior to v5.7.6` the 14.04 repo satisfies this requirement.

2. Install GD for PHP5 `apt-get install php5-gd`
3. Remove `Indexes` from Apache config (disable directory browsing)
4. enable `mod_rewrite` & `mod_expires` for Apache
5. Ensure the web app can write to the following directories (and sub-directories):

  * /templates/templates_c/

  * /images/uploads/*

6. Create a blank `ashley` database and import the tables from `/no_prod/restart.sql`
7. Setup SQL users (see Game Credentials below)
8. Edit the path on `line 4` of the `.htaccess` file

  * **If** you plan on running the game under a directory (`example.com/ashley/`) you'll need to update `/includes/config.php` line 18 and `/backups/api_config.php` line 13 **as well**

9. Move the `flag2.txt` file from the `no_prod` directory to outside the web directory root

  * It should be `../flag2.txt` from the directory with this readme in it

10. Remove the `no_prod` and `.git` directories and this `README.md` file from your deployment machine
11. Recommended: Setup [Let's Encrypt](https://certbot.eff.org/all-instructions/#ubuntu-14-04-trusty-apache) for your game

## Restarting Game
If you have deployed the game and now want to restart it - use the `/no_prod/restart_game.sh` script. The script can be run from anywhere; however, requires the `/no_prod/restart.sql` file in the same directory. Run `./restart_game.sh` (with no arguments) to get instructions on how to use the script.

## Game Credentials
The game requires two MySQL users with the following permissions, if you want to change the passwords you can find them in:
* /includes/config.php
* /backups/api_config.php

MySQL account #1:
* Username: `priv_ashley`
* Password: `YvscGRYVL4Hza7AN`
* SELECT,INSERT,UPDATE,DELETE,LOCK TABLES

MySQL account #2:
* Username: `unpriv_ashley`
* Password: `njuxw4haW2pxvhHf`
* SELECT,LOCK TABLES
