# BasiC - A Basic Language interpreter with a (somewhat?) 'C' flavor#

...implemented in PHP.

### About ###

* Very incomplete currently, and not too much on the 'C' flavor, either
* Lexer is working ok - turning the example BASIC into tokens
* Check out the recursive operations parser (hmm - just realized I am missing parentheses parsing, and order ops - oh well)
* Hey - I've never done this before (much - though there was this one time in VB 5.0 where I...)

Ultimately, should I finish this, I have grand plans (which I probably won't get to) to re-implement the code in C/C++ for the Arduino, with the code and everything running from a flash RAM chip (via SPI) hanging off the ATMega328P - and the whole interpreter running out of the ATMega's flash EEPROM and RAM (something like the Parallax BASIC Stamp). Yeah, I know it's been done before, but I just want to see how far I can get, considering I don't have much of a background in building an interpreter from scratch. Oh - and I guess I will need to build a bootloader for the Arduino, too...hmm.

### Who do I cuss out? ###

* Andrew L. Ayers - junkbotix@gmail.com
* http://www.phoenixgarage.org/