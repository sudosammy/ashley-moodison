#!/bin/bash
AMPATH="/var/www/html" # path to the web root for AM - no trailing slash
SQLFILE="restart.sql" # name of .sql file containing the fresh database
SCRIPT=`basename "$0"`

if [[ $# -eq 0 ]]; then
  printf "=== RESTART ASHLEY MOODISON ===\n"
  printf "Provide the MySQL root password as the first argument and (only if different than what's shown below) the absolute path to the games root directory without a trailing slash as the second argument:\n\n"
  printf "./$SCRIPT YOUR_MYSQL_ROOT_PASSWD $AMPATH\n\n"
  printf "Also, make sure the $SQLFILE file is in the same directory as this script.\n"
  printf "=== END ===\n"
  exit 1
fi

if [[ ! -f $SQLFILE ]]; then # Check .sql file is available
  printf "Make sure $SQLFILE is in the same directory as this script. Exiting.\n"
  exit 1
fi

if [[ -z $1 ]]; then # Check MySQL password was supplied
  printf "You need to supply your MySQL root password so the script can refresh the database. Exiting.\n"
  exit 1
fi

if [[ -z $2 ]]; then # Check default path if not provided as an arg
  if [ ! -d "$AMPATH/images/uploads/" ]; then
    printf "Incorrect path. Could not find directory: $AMPATH/images/uploads/ \n"
    exit 1
  fi
else
  if [[ ! -d "$2/images/uploads/" ]]; then # Check path if provided as an arg
    printf "Incorrect path. Could not find directory: $AMPATH/images/uploads/ \n"
    exit 1
  else
    AMPATH = $2 # Update path value
  fi
fi

# Reset database
mysql -u root -p$1 ashley < $SQLFILE
# Delete image files but not the directory in /uploads/
shopt -s extglob
RMPATH="$AMPATH/images/uploads/"
find $RMPATH -type f -not -name 'Administrator-712.jpeg' -not -name 'Lucy-861.jpeg' -not -name 'Sam-194.png' | xargs rm

# Show completed message and exit
printf "Complete. You should check:\n"
printf "$RMPATH has the standard three images and a directory in it.\n"
printf "The game still loads in your browser.\n"
printf "If it doesn't, good luck! ^_^\n"
exit 0
