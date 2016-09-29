# pixel-php-classic

This is an implementation of http://youpixelart.com written in a very simple classic PHP style using only plain scripts.
It uses no fancy frameworks, no SOLID, but DRY and KISS instead.

The idea is to create a crowd pixel art editor with a loop of one million pixels (278 looped images of 60x60 pixels) which can be used online by many people at the same time.

This work is intended for participating in https://a-k-apart.com contest, so it meets the following requirements:

* The front-end code is limited to 10KB including all the assets
* It uses progressive enhancements and works well enough even without JavaScript
* Actually the back-end code meets 10KB limit as well, although it's not a requirement of the contest :)

![10k-proof](/10k-proof.png)

For the first run with sqlite, please give it some time to finish the initialization things as it can take even 30 seconds.
