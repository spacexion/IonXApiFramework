#!/bin/sh

INSTALL_DIR="../vendor/"

#Create install folder if it does not exist
if [ ! -d "$INSTALL_DIR" ]; then
    mkdir --parents "$INSTALL_DIR"
    if [ $? -ne 0 ] ; then
        echo "There was an error while creating the install folder at : $INSTALL_DIR"
        exit
    fi
fi

if type "php" &> /dev/null; then

    php -r "readfile('https://getcomposer.org/installer');" | php
    php composer.phar install

else
    echo "There is no php in your PATH, have you installed it ?"
fi